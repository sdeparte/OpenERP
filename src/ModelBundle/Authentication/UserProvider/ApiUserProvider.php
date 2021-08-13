<?php

namespace App\ModelBundle\Authentication\UserProvider;

use App\ModelBundle\Authentication\Model\ApiUser;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @method UserInterface loadUserByIdentifier(string $identifier)
 */
class ApiUserProvider implements UserProviderInterface
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    public function __construct(SessionInterface $session, HttpClientInterface $msHttpClient)
    {
        $this->session = $session;
        $this->httpClient = $msHttpClient;
    }

    public function refreshUser(UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    public function supportsClass(string $class)
    {
        // TODO: Implement supportsClass() method.
    }

    public function loadUserByUsername(string $username)
    {
        // TODO: Implement loadUserByUsername() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method UserInterface loadUserByIdentifier(string $identifier)
    }
}