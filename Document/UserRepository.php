<?php

namespace OpenSky\Bundle\GigyaBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;

class UserRepository extends DocumentRepository
{
    /**
     * @param array $providers
     * @return \Doctrine\ODM\MongoDB\Cursor $cursor
     */
    public function findByProviders(array $providers)
    {
        $qb = $this->createQueryBuilder();
        foreach ($providers as $key => $value) {
            $qb->field('providers.'.$key);
            $qb->addOr($qb->expr()->field('providers.'.$key)->equals($value));
        }

        return $qb->getQuery()->execute();
    }
}
