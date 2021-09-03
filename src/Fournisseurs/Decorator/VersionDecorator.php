<?php

namespace App\Fournisseurs\Decorator;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

class VersionDecorator implements OpenApiFactoryInterface
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

        $openApi->getPaths()->addPath('/versions/{id}/add_reference_fournisseur', $this->getAddReferenceFournisseurPathItem());
        $openApi->getPaths()->addPath('/versions/remove_reference_fournisseur', $this->getRemoveReferenceFournisseurPathItem());
        $openApi->getPaths()->addPath('/versions/{id}/add_parametre', $this->getAddParametrePathItem());
        $openApi->getPaths()->addPath('/versions/remove_parametre', $this->getRemoveParametrePathItem());

        return $openApi;
    }

    private function buildSchema(OpenApi $openApi) {
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['ReferenceFournisseur'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'referenceFournisseurIri' => [
                    'type' => 'string',
                ],
            ],
        ]);

        $schemas['Parametre'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'parametreIri' => [
                    'type' => 'string',
                ],
            ],
        ]);
    }

    private function getAddReferenceFournisseurPathItem()
    {
        $parameter = new Model\Parameter(
            'id',
            'path',
            'Resource identifier',
            true
        );

        $requestBody = new Model\RequestBody(
            'Add Reference Fournisseur to Version',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/ReferenceFournisseur',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Add Reference Fournisseur to Version',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postAddReferenceFournisseurToVersionItem',
                ['Version'],
                [
                    '204' => [
                        'description' => 'Reference Fournisseur added to Version',
                    ],
                ],
                'Add Reference Fournisseur to Version.',
                '',
                null,
                [$parameter],
                $requestBody
            )
        );
    }

    private function getRemoveReferenceFournisseurPathItem()
    {
        $requestBody = new Model\RequestBody(
            'Remove Reference Fournisseur from all Versions',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/ReferenceFournisseur',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Remove Reference Fournisseur from all Versions',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postRemoveReferenceFournisseurToVersionItem',
                ['Version'],
                [
                    '204' => [
                        'description' => 'Reference Fournisseur removed from all Versions',
                    ],
                ],
                'Remove Reference Fournisseur from all Versions.',
                '',
                null,
                [],
                $requestBody
            )
        );
    }

    private function getAddParametrePathItem()
    {
        $parameter = new Model\Parameter(
            'id',
            'path',
            'Resource identifier',
            true
        );

        $requestBody = new Model\RequestBody(
            'Add Parametre to Version',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Parametre',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Add Parametre to Version',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postAddParametreToVersionItem',
                ['Version'],
                [
                    '204' => [
                        'description' => 'Parametre added to Version',
                    ],
                ],
                'Add Parametre to Version.',
                '',
                null,
                [$parameter],
                $requestBody
            )
        );
    }

    private function getRemoveParametrePathItem()
    {
        $requestBody = new Model\RequestBody(
            'Remove Parametre from all Versions',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Parametre',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Remove Parametre from all Versions',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postRemoveParametreToVersionItem',
                ['Version'],
                [
                    '204' => [
                        'description' => 'Parametre removed from all Versions',
                    ],
                ],
                'Remove Parametre from all Versions.',
                '',
                null,
                [],
                $requestBody
            )
        );
    }
}