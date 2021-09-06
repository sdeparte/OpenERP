<?php

namespace App\Common\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Common\Documents\Contact;
use Doctrine\ODM\MongoDB\DocumentManager;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ContactDataPersister implements ContextAwareDataPersisterInterface
{
    private DocumentManager $documentManager;

    private HttpClientInterface $httpClient;

    private ValidatorInterface $validator;

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
        return $data instanceof Contact;
    }

    /**
     * @param Contact $data
     */
    public function persist($data, array $context = [])
    {
        $this->validator->validate($data);

        $this->documentManager->persist($data);
        $this->documentManager->flush();

        $response = $this->httpClient->request('POST', 'http://api.erp.docker/api/versions/'.$data->getFromIri()->getId().'/add_contact', [
            'body' => json_encode(['contactIri' => '/api/contacts/'.$data->getId()]),
        ]);

        if (Response::HTTP_NO_CONTENT !== $response->getStatusCode()) {
            $this->documentManager->remove($data);
            $this->documentManager->flush();

            throw new \Exception('Impossible d\'ajouter le contact.', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Contact $data
     */
    public function remove($data, array $context = [])
    {
        // @TODO: Passer avec messenger !
        $response = $this->httpClient->request('POST', 'http://api.erp.docker/api/fournisseurs/remove_contact', [
            'body' => json_encode(['contactIri' => '/api/contacts/'.$data->getId()]),
        ]);

        if (Response::HTTP_NO_CONTENT !== $response->getStatusCode()) {
            throw new \Exception('Impossible de supprimer le contact.', Response::HTTP_BAD_REQUEST);
        }

        $this->documentManager->remove($data);
        $this->documentManager->flush();
    }
}