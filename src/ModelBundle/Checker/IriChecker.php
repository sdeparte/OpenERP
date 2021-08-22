<?php

namespace App\ModelBundle\Checker;


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

    public function getIriExistenceStatuses(string $microService, array $iris): array
    {
        $result = [];

        foreach ($iris as $iri) {
            $result[$iri] = $this->httpClient->request('GET', 'http://api.erp.docker'.$iri)->getStatusCode();
        }

        return $result;
    }
}