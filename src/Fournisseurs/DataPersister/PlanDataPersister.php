<?php

namespace App\Fournisseurs\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Fournisseurs\Documents\Plan;
use App\Fournisseurs\Repositories\PlanRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PlanDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var DocumentManager
     */
    private $documentManager;

    public function __construct(TokenExtractorInterface $tokenExtractor, RequestStack $requestStack, HttpClientInterface $httpClient, DocumentManager $documentManager)
    {
        $token = $tokenExtractor->extract($requestStack->getCurrentRequest());

        $this->httpClient = $httpClient->withOptions([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ]
        ]);

        $this->documentManager = $documentManager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Plan;
    }

    /**
     * @param Plan $data
     */
    public function persist($data, array $context = [])
    {
        /** @var PlanRepository $repository */
        $repository = $this->documentManager->getRepository(Plan::class);
        $lastPlan = $repository->findLastIndiceOfArticle($data->getArticleIri());

        if (!empty($lastPlan)) {
            $indice = $lastPlan->getIndice();
            $data->setIndice(++$indice);
        }

        $this->documentManager->persist($data);
        $this->documentManager->flush();

        $response = $this->httpClient->request('POST', 'http://api.erp.docker'.$data->getArticleIri().'/add_plan', [
            'body' => '{"planIri": "/api/plans/'.$data->getId().'"}',
        ]);

        if (Response::HTTP_NO_CONTENT !== $response->getStatusCode()) {
            $this->documentManager->remove($data);
            $this->documentManager->flush();

            throw new \Exception('Impossible d\'ajouter le plan dans l\'article.', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Plan $data
     */
    public function remove($data, array $context = [])
    {
        $response = $this->httpClient->request('POST', 'http://api.erp.docker/api/articles/remove_plan', [
            'body' => '{"planIri": "/api/plans/'.$data->getId().'"}',
        ]);

        if (Response::HTTP_NO_CONTENT !== $response->getStatusCode()) {
            throw new \Exception('Impossible de supprimer le plan.', Response::HTTP_BAD_REQUEST);
        }

        $this->documentManager->remove($data);
        $this->documentManager->flush();
    }
}