<?php

namespace App\Fournisseurs\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Fournisseurs\Documents\Version;
use App\Fournisseurs\Repositories\VersionRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class VersionDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var DocumentManager
     */
    private $documentManager;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(TokenExtractorInterface $tokenExtractor, RequestStack $requestStack, HttpClientInterface $httpClient, DocumentManager $documentManager, ValidatorInterface $validator)
    {
        $token = $tokenExtractor->extract($requestStack->getCurrentRequest());

        $this->httpClient = $httpClient->withOptions([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ]
        ]);

        $this->documentManager = $documentManager;
        $this->validator = $validator;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Version;
    }

    /**
     * @param Version $data
     */
    public function persist($data, array $context = [])
    {
        $this->validator->validate($data);

        /** @var VersionRepository $repository */
        $repository = $this->documentManager->getRepository(Version::class);
        $lastPlan = $repository->findLastVersionOfArticle($data->getArticleIri());

        if (!empty($lastPlan)) {
            $lettres = $lastPlan->getLettres();
            $data->setLettres(++$lettres);
        }

        $this->documentManager->persist($data);
        $this->documentManager->flush();

        $response = $this->httpClient->request('POST', 'http://api.erp.docker'.$data->getArticleIri().'/add_version', [
            'body' => '{"versionIri": "/api/versions/'.$data->getId().'"}',
        ]);

        if (Response::HTTP_NO_CONTENT !== $response->getStatusCode()) {
            $this->documentManager->remove($data);
            $this->documentManager->flush();

            throw new \Exception('Impossible d\'ajouter la version dans l\'article.', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Version $data
     */
    public function remove($data, array $context = [])
    {
        $response = $this->httpClient->request('POST', 'http://api.erp.docker/api/articles/remove_version', [
            'body' => '{"versionIri": "/api/versions/'.$data->getId().'"}',
        ]);

        if (Response::HTTP_NO_CONTENT !== $response->getStatusCode()) {
            throw new \Exception('Impossible de supprimer la version.', Response::HTTP_BAD_REQUEST);
        }

        $this->documentManager->remove($data);
        $this->documentManager->flush();
    }
}