<?php

namespace App\ModelBundle\Iri;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IriGetter
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getIri(string $iri): ?array
    {
        $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$iri);

        if (Response::HTTP_OK === $response->getStatusCode()) {
            return json_decode(
                $response->getContent(), true
            );
        }

        return null;
    }
}