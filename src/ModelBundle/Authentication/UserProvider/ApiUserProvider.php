<?php

namespace App\ModelBundle\Authentication\UserProvider;

use App\ModelBundle\Authentication\Model\ApiUser;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @method UserInterface loadUserByIdentifier(string $identifier)
 */
class ApiUserProvider implements UserProviderInterface
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var TokenExtractorInterface
     */
    protected $tokenExtractor;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    public function __construct(HttpClientInterface $httpClient, TokenExtractorInterface $tokenExtractor, RequestStack $requestStack)
    {
        $this->httpClient = $httpClient;
        $this->tokenExtractor = $tokenExtractor;
        $this->requestStack = $requestStack;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return ApiUser::class === $class;
    }

    public function loadUserByUsername(string $username): ApiUser
    {
        return $this->getMicroServiceUser($username);
    }

    public function __call($name, $arguments): ApiUser
    {
        return $this->getMicroServiceUser($name);
    }

    private function getMicroServiceUser($identity): ApiUser
    {
        $token = $this->tokenExtractor->extract($this->requestStack->getCurrentRequest());

        /** @var HttpClientInterface $httpClient */
        $httpClient = $this->httpClient->withOptions([
            'headers' => ['Authorization' => 'Bearer '.$token]
        ]);

        try {
            $response = $httpClient->request('GET', 'http://api.erp.docker/api/utilisateurs?username='.$identity);

            if ($response->getStatusCode() &&
                isset(json_decode($response->getContent(), true)['hydra:member'][0])
            ) {
                $userAsArray = json_decode($response->getContent(), true)['hydra:member'][0];

                return new ApiUser($userAsArray['username'], null, $userAsArray['roles']);
            }
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
        }

        throw new UserNotFoundException("User not found in 'Users' micro-service.");
    }
}