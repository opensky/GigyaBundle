<?php

namespace OpenSky\Bundle\GigyaBundle\User;

use Doctrine\ODM\MongoDB\DocumentManager;
use OpenSky\Bundle\GigyaBundle\Socializer;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedAccountException;
use Symfony\Component\Security\Core\User\AccountInterface;
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
    public function loadUserByAccount(AccountInterface $account)
    {

    }

    /**
     * @param array $providers
     * @return AccountInterface | null
     * @throws AuthenticationCredentialsNotFoundException
     * @throws UnsupportedAccountException
     */
    public function loadUserByProviders(array $providers)
    {
		$result = $this->repository->findByProviders($providers);
        if ($result->count() == 0) {
            throw new AuthenticationCredentialsNotFoundException('User not found by providers '.print_r($providers, true));
        }
        if ($result->count() > 1) {
            throw new UnsupportedAccountException('Multiple users found by providers '.print_r($providers, true));
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
