<?php

namespace OpenSky\Bundle\GigyaBundle\Security;

use Doctrine\ODM\MongoDB\DocumentManager;
use OpenSky\Bundle\GigyaBundle\Socializer;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $class;
    private $documentManager;
    private $repository;

    public function __construct(DocumentManager $documentManager, $class)
    {
        $this->documentManager = $documentManager;
        $metadata = $documentManager->getClassMetadata($class);
        $this->class = $metadata->name;
        $this->repository = $documentManager->getRepository($class);
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function loadUser(UserInterface $user)
    {

    }

    /**
     * @param array $providers
     * @return UserInterface | null
     * @throws AuthenticationCredentialsNotFoundException
     * @throws UnsupportedUserException
     */
    public function loadUserByProviders(array $providers)
    {
		$result = $this->repository->findByProviders($providers);
        if ($result->count() == 0) {
            throw new AuthenticationCredentialsNotFoundException('User not found by providers '.print_r($providers, true));
        }
        if ($result->count() > 1) {
            throw new UnsupportedUserException('Multiple users found by providers '.print_r($providers, true));
        }
        return $result->getSingleResult();
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === $this->getClass();
    }
}
