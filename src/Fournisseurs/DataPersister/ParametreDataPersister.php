<?php

namespace App\Fournisseurs\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Fournisseurs\Documents\Parametre;
use Doctrine\ODM\MongoDB\DocumentManager;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParametreDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof Parametre;
    }

    /**
     * @param Parametre $data
     */
    public function persist($data, array $context = [])
    {
        $this->validator->validate($data);

        $this->documentManager->persist($data);
        $this->documentManager->flush();

        $response = $this->httpClient->request('POST', 'http://api.erp.docker'.$data->getVersionIri().'/add_parametre', [
            'body' => '{"parametreIri": "/api/parametres/'.$data->getId().'"}',
        ]);

        if (Response::HTTP_NO_CONTENT !== $response->getStatusCode()) {
            $this->documentManager->remove($data);
            $this->documentManager->flush();

            throw new \Exception('Impossible d\'ajouter le paramètre dans la version.', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Parametre $data
     */
    public function remove($data, array $context = [])
    {
        $response = $this->httpClient->request('POST', 'http://api.erp.docker/api/versions/remove_parametre', [
            'body' => '{"parametreIri": "/api/parametres/'.$data->getId().'"}',
        ]);

        if (Response::HTTP_NO_CONTENT !== $response->getStatusCode()) {
            throw new \Exception('Impossible de supprimer le paramètre.', Response::HTTP_BAD_REQUEST);
        }

        $this->documentManager->remove($data);
        $this->documentManager->flush();
    }
}