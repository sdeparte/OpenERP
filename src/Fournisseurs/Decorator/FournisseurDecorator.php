<?php

namespace App\Fournisseurs\Decorator;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

class FournisseurDecorator implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;

    public function __construct(OpenApiFactoryInterface $decorated) {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        $this->buildSchema($openApi);

        $openApi->getPaths()->addPath('/api/fournisseurs/{id}/add_contact', $this->getAddContactPathItem());
        $openApi->getPaths()->addPath('/api/fournisseurs/remove_contact', $this->getRemoveContactPathItem());

        return $openApi;
    }

    private function buildSchema(OpenApi $openApi) {
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Contact'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'contactIri' => [
                    'type' => 'string',
                ],
            ],
        ]);
    }

    private function getAddContactPathItem()
    {
        $parameter = new Model\Parameter(
            'id',
            'path',
            'Resource identifier',
            true
        );

        $requestBody = new Model\RequestBody(
            'Add Contact to Fournisseur',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Contact',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Add Contact to Fournisseur',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postAddContactToFournisseurItem',
                ['Fournisseur'],
                [
                    '204' => [
                        'description' => 'Contact added to Fournisseur',
                    ],
                ],
                'Add Contact to Fournisseur.',
                '',
                null,
                [$parameter],
                $requestBody
            )
        );
    }

    private function getRemoveContactPathItem()
    {
        $requestBody = new Model\RequestBody(
            'Remove Contact from all Fournisseurs',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Contact',
                    ],
                ],
            ])
        );

        return new Model\PathItem(
            'Remove Contact from all Fournisseurs',
            null,
            null,
            null,
            null,
            new Model\Operation(
                'postRemoveContactToFournisseurItem',
                ['Fournisseur'],
                [
                    '204' => [
                        'description' => 'Contact removed from all Fournisseurs',
                    ],
                ],
                'Remove Contact from all Fournisseurs.',
                '',
                null,
                [],
                $requestBody
            )
        );
    }
}