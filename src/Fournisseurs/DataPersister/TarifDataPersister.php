<?php


namespace App\Fournisseurs\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Fournisseurs\Documents\Tarif;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TarifDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var DocumentManager
     */
    private $documentManager;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(DocumentManager $documentManager, HttpClientInterface $httpClient, TokenStorageInterface $tokenStorage)
    {
        $this->documentManager = $documentManager;

        $this->httpClient = $httpClient->withOptions([
            'headers' => ['Authorization' => 'Bearer '.$tokenStorage->getToken()]
        ]);
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Tarif;
    }

    /**
     * @param Tarif $data
     */
    public function persist($data, array $context = [])
    {
        $this->documentManager->persist($data);
        $this->documentManager->flush();

        $response = $this->httpClient->request('POST', 'http://api.erp.docker'.$data->getArticleIri().'/add_tarif', [
            'body' => ['tarifIri' => '/api/tarifs/'.$data->getId()]
        ]);

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            $this->documentManager->remove($data);
            $this->documentManager->flush();

            throw new \Exception('Impossible d\'ajouter le tarif dans l\'article.', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Tarif $data
     */
    public function remove($data, array $context = [])
    {
        $response = $this->httpClient->request('POST', 'http://api.erp.docker/api/articles/remove_tarif', [
            'body' => '{"planIri": "/api/tarifs/'.$data->getId().'"}',
        ]);

        if (Response::HTTP_NO_CONTENT !== $response->getStatusCode()) {
            throw new \Exception('Impossible de supprimer le tarif.', Response::HTTP_BAD_REQUEST);
        }

        $this->documentManager->remove($data);
        $this->documentManager->flush();
    }
}