<?php

namespace App\ModelBundle\Checker;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class IriChecker
{
    public static $microServicesMapper = [
        'Common' => 'http://common.erp.docker ',
        'Users' => 'http://users.erp.docker',
        'Employes' => 'http://employes.erp.docker',
    ];
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface  $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getIriExistenceStatuses(string $microService, array $iris): array
    {
        $result = [];
        foreach ($iris as $iri) {
            $result[$iri] = $this->httpClient->request('GET', self::$microServicesMapper[$microService].$iri)->getStatusCode();
        }

        return $result;
    }
}