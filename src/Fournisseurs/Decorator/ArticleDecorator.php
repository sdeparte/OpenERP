<?php

namespace App\Fournisseurs\Decorator;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

class ArticleDecorator implements OpenApiFactoryInterface
{
    /**
     * @var OpenApiFactoryInterface
     */
    private $decorated;

    /**
     * JwtDecorator constructor.
     *
     * @param OpenApiFactoryInterface $decorated
     */
    public function __construct(OpenApiFactoryInterface $decorated) {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        $this->buildSchema($openApi);

        $openApi->getPaths()->addPath('/articles/{id}/add_version', $this->getAddVersionPathItem());
        $openApi->getPaths()->addPath('/articles/remove_version', $this->getRemoveVersionPathItem());

        return $openApi;
    }

    private function buildSchema(OpenApi $openApi) {
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Version'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'versionIri' => [
                    'type' => 'string',
                ],
            ],
        ]);
    }

    private function getAddVersionPathItem()
    {
        $parameter = new Model\Parameter(
            'id',
            'path',
            'Resource identifier',
            true
        );

        $requestBody = new Model\RequestBody(
            'Add Version to Article',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Version',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Add Version to Article',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postAddVersionToArticleItem',
                ['Article'],
                [
                    '204' => [
                        'description' => 'Version added to Article',
                    ],
                ],
                'Add Version to Article.',
                '',
                null,
                [$parameter],
                $requestBody
            )
        );
    }

    private function getRemoveVersionPathItem()
    {
        $requestBody = new Model\RequestBody(
            'Remove Version from all Articles',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Version',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Remove Version from all Articles',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postRemoveVersionToArticleItem',
                ['Article'],
                [
                    '204' => [
                        'description' => 'Version removed from all Articles',
                    ],
                ],
                'Remove Version from all Articles.',
                '',
                null,
                [],
                $requestBody
            )
        );
    }
}