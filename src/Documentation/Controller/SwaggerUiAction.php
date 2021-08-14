<?php

namespace App\Documentation\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\SwaggerUi\SwaggerUiContext;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Options;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Environment as TwigEnvironment;

class SwaggerUiAction
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var TwigEnvironment|null
     */
    private $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var NormalizerInterface
     */
    private $normalizer;

    /**
     * @var OpenApiFactoryInterface
     */
    private $openApiFactory;

    /**
     * @var Options
     */
    private $openApiOptions;

    /**
     * @var SwaggerUiContext
     */
    private $swaggerUiContext;

    /**
     * @var array
     */
    private $formats;

    /**
     * @var ResourceMetadataFactoryInterface
     */
    private $resourceMetadataFactory;

    /**
     * @var string|null
     */
    private $oauthClientId;

    /**
     * @var string|null
     */
    private $oauthClientSecret;

    public function __construct(HttpClientInterface $httpClient, ResourceMetadataFactoryInterface $resourceMetadataFactory, ?TwigEnvironment $twig, UrlGeneratorInterface $urlGenerator, NormalizerInterface $normalizer, OpenApiFactoryInterface $openApiFactory, Options $openApiOptions, SwaggerUiContext $swaggerUiContext, array $formats = [], string $oauthClientId = null, string $oauthClientSecret = null)
    {
        $this->httpClient = $httpClient;
        $this->resourceMetadataFactory = $resourceMetadataFactory;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
        $this->normalizer = $normalizer;
        $this->openApiFactory = $openApiFactory;
        $this->openApiOptions = $openApiOptions;
        $this->swaggerUiContext = $swaggerUiContext;
        $this->formats = $formats;
        $this->oauthClientId = $oauthClientId;
        $this->oauthClientSecret = $oauthClientSecret;

        if (null === $this->twig) {
            throw new \RuntimeException('The documentation cannot be displayed since the Twig bundle is not installed. Try running "composer require symfony/twig-bundle".');
        }
    }

    public function __invoke(Request $request)
    {
        $openApi = $this->openApiFactory->__invoke(['base_url' => $request->getBaseUrl() ?: '/']);

        $swaggerContext = [
            'formats' => $this->formats,
            'title' => $openApi->getInfo()->getTitle(),
            'description' => $openApi->getInfo()->getDescription(),
            'showWebby' => $this->swaggerUiContext->isWebbyShown(),
            'swaggerUiEnabled' => $this->swaggerUiContext->isSwaggerUiEnabled(),
            'reDocEnabled' => $this->swaggerUiContext->isRedocEnabled(),
            // FIXME: typo graphql => graphQl
            'graphqlEnabled' => $this->swaggerUiContext->isGraphQlEnabled(),
            'graphiQlEnabled' => $this->swaggerUiContext->isGraphiQlEnabled(),
            'graphQlPlaygroundEnabled' => $this->swaggerUiContext->isGraphQlPlaygroundEnabled(),
            'assetPackage' => $this->swaggerUiContext->getAssetPackage(),
        ];

        $swaggerData = [
            'url' => $this->urlGenerator->generate('api_doc', ['format' => 'json']),
            'spec' => $this->normalizer->normalize($this->buildMicroServicesOpenApi(), 'json', []),
            'oauth' => [
                'enabled' => $this->openApiOptions->getOAuthEnabled(),
                'type' => $this->openApiOptions->getOAuthType(),
                'flow' => $this->openApiOptions->getOAuthFlow(),
                'tokenUrl' => $this->openApiOptions->getOAuthTokenUrl(),
                'authorizationUrl' => $this->openApiOptions->getOAuthAuthorizationUrl(),
                'scopes' => $this->openApiOptions->getOAuthScopes(),
                'clientId' => $this->oauthClientId,
                'clientSecret' => $this->oauthClientSecret,
            ],
        ];

        if ($request->isMethodSafe() && null !== $resourceClass = $request->attributes->get('_api_resource_class')) {
            $swaggerData['id'] = $request->attributes->get('id');
            $swaggerData['queryParameters'] = $request->query->all();

            $metadata = $this->resourceMetadataFactory->create($resourceClass);
            $swaggerData['shortName'] = $metadata->getShortName();

            if (null !== $collectionOperationName = $request->attributes->get('_api_collection_operation_name')) {
                $swaggerData['operationId'] = sprintf('%s%sCollection', $collectionOperationName, ucfirst($swaggerData['shortName']));
            } elseif (null !== $itemOperationName = $request->attributes->get('_api_item_operation_name')) {
                $swaggerData['operationId'] = sprintf('%s%sItem', $itemOperationName, ucfirst($swaggerData['shortName']));
            } elseif (null !== $subresourceOperationContext = $request->attributes->get('_api_subresource_context')) {
                $swaggerData['operationId'] = $subresourceOperationContext['operationId'];
            }

            [$swaggerData['path'], $swaggerData['method']] = $this->getPathAndMethod($swaggerData);
        }

        return new Response($this->twig->render('@ApiPlatform/SwaggerUi/index.html.twig', $swaggerContext + ['swagger_data' => $swaggerData]));
    }

    private function getPathAndMethod(array $swaggerData): array
    {
        foreach ($swaggerData['spec']['paths'] as $path => $operations) {
            foreach ($operations as $method => $operation) {
                if (($operation['operationId'] ?? null) === $swaggerData['operationId']) {
                    return [$path, $method];
                }
            }
        }

        throw new RuntimeException(sprintf('The operation "%s" cannot be found in the Swagger specification.', $swaggerData['operationId']));
    }

    /**
     * Build the Micro Services OpenApi.
     *
     * @return array
     */
    private function buildMicroServicesOpenApi(): array
    {
        if (!getenv('API_GATEWAY_URLS')) {
            throw new \RuntimeException('API_GATEWAY_URLS is not set.');
        }

        if (!getenv('MICRO_SERVICE_URLS')) {
            throw new \RuntimeException('MICRO_SERVICE_URLS is not set.');
        }

        $microServiceUrls = explode(';', getenv('MICRO_SERVICE_URLS'));
        $openApi = [];

        foreach ($microServiceUrls as $microServiceUrl) {
            try {
                $json = $this->httpClient->request('GET', $microServiceUrl.'docs.json')->getContent();
            } catch (\Exception $e) {
                continue;
            }

            $openApiNormalized = \json_decode($json, true);

            if ([] === $openApi) {
                $openApi = $openApiNormalized;
            } else {
                $openApi['paths'] = array_merge(
                    $openApi['paths'],
                    $openApiNormalized['paths']
                );

                $openApi['components']['schemas'] = array_merge(
                    $openApi['components']['schemas'],
                    $openApiNormalized['components']['schemas']
                );
            }
        }

        $openApi['servers'] = [];
        $apiGatewayUrls = explode(';', getenv('API_GATEWAY_URLS'));

        foreach ($apiGatewayUrls as $apiGatewayUrl) {
            $openApi['servers'][] = [
                'url' => $apiGatewayUrl,
                'description' => '',
            ];
        }

        return $openApi;
    }
}