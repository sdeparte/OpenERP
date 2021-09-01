<?php

namespace App\ModelBundle\Authentication\UserProvider;

use App\ModelBundle\Authentication\Model\ApiUser;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Serializer\SerializerInterface;
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
    private $httpClient;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(TokenExtractorInterface $tokenExtractor, RequestStack $requestStack, HttpClientInterface $httpClient, SerializerInterface $serializer)
    {
        $token = $tokenExtractor->extract($requestStack->getCurrentRequest());

        $this->httpClient = $httpClient->withOptions([
            'headers' => [
                'accept' => 'application/ld+json',
                'Authorization' => 'Bearer '.$token,
            ]
        ]);

        $this->serializer = $serializer;
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
        try {
            $response = $this->httpClient->request('GET', 'http://api.erp.docker/api/utilisateurs/by_username/'.$identity);

            if ($response->getStatusCode()) {
                return $this->serializer->deserialize($response->getContent(), ApiUser::class, 'json');
            }
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
        }

        throw new UserNotFoundException("User not found in 'Users' micro-service.");
    }
}