<?php

namespace App\ModelBundle\Checker;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IriChecker
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getIriExistenceStatuses(array $types, array $iris): array
    {
        $result = [];

        foreach ($iris as $iri) {
            $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$iri);

            if (Response::HTTP_OK === $response->getStatusCode()) {
                $responseAsArray = json_decode(
                    $response->getContent(), true
                );
            }

            if (!isset($result[$iri]) || !$result[$iri]) {
                $result[$iri] = isset($responseAsArray['@type']) && in_array($responseAsArray['@type'], $types);
            }
        }

        return $result;
    }
}