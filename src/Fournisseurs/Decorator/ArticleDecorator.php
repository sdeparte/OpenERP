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

        $openApi->getPaths()->addPath('/articles/{id}/add_tarif', $this->getAddTarifPathItem());
        $openApi->getPaths()->addPath('/articles/remove_tarif', $this->getRemoveTarifPathItem());
        $openApi->getPaths()->addPath('/articles/{id}/add_plan', $this->getAddPlanPathItem());
        $openApi->getPaths()->addPath('/articles/remove_plan', $this->getRemovePlanPathItem());

        return $openApi;
    }

    private function buildSchema(OpenApi $openApi) {
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Tarif'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'tarif_iri' => [
                    'type' => 'string',
                ],
            ],
        ]);

        $schemas['Plan'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'plan_iri' => [
                    'type' => 'string',
                ],
            ],
        ]);
    }

    private function getAddTarifPathItem()
    {
        $parameter = new Model\Parameter(
            'id',
            'path',
            'Resource identifier',
            true
        );

        $requestBody = new Model\RequestBody(
            'Add Tarif to Article',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Tarif',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Add Tarif to Article',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postAddTarifToArticleItem',
                ['Article'],
                [
                    '204' => [
                        'description' => 'Tarif added to Article',
                    ],
                ],
                'Add Tarif to Article.',
                '',
                null,
                [$parameter],
                $requestBody
            )
        );
    }

    private function getRemoveTarifPathItem()
    {
        $requestBody = new Model\RequestBody(
            'Remove Tarif from all Articles',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Tarif',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Remove Tarif from all Articles',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postRemoveTarifToArticleItem',
                ['Article'],
                [
                    '204' => [
                        'description' => 'Tarif removed from all Articles',
                    ],
                ],
                'Remove Tarif from all Articles.',
                '',
                null,
                [],
                $requestBody
            )
        );
    }

    private function getAddPlanPathItem()
    {
        $parameter = new Model\Parameter(
            'id',
            'path',
            'Resource identifier',
            true
        );

        $requestBody = new Model\RequestBody(
            'Add Plan to Article',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Plan',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Add Plan to Article',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postAddPlanToArticleItem',
                ['Article'],
                [
                    '204' => [
                        'description' => 'Plan added to Article',
                    ],
                ],
                'Add Plan to Article.',
                '',
                null,
                [$parameter],
                $requestBody
            )
        );
    }

    private function getRemovePlanPathItem()
    {
        $requestBody = new Model\RequestBody(
            'Remove Plan from all Articles',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Plan',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Remove Plan from all Articles',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postRemovePlanToArticleItem',
                ['Article'],
                [
                    '204' => [
                        'description' => 'Plan removed from all Articles',
                    ],
                ],
                'Remove Plan from all Articles.',
                '',
                null,
                [],
                $requestBody
            )
        );
    }
}