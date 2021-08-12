<?php

namespace App\ModelBundle\Checker;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class IriExistenceChecker
{
    private $httpClient;

    public function __construct(HttpClientInterface  $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getIriExistenceStatuses(string $microService, array $iris): array
    {
        $result = [];

        foreach ($iris as $iri) {
            $result[$iri] = $this->httpClient->request('POST', $microService.'/'.$iri)->getStatusCode();
        }

        return $result;
    }
}