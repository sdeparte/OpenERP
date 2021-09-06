<?php


namespace App\Users\DataProvider;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Users\Documents\Utilisateur;
use Doctrine\ODM\MongoDB\DocumentManager;

class UtilisateurItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private DocumentManager $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Utilisateur::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Utilisateur
    {
        return $this->documentManager->getRepository(Utilisateur::class)->findOneBy(['username' => $id]);
    }
}