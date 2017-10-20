<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Users;
use Doctrine\ORM\Mapping;

/**
 * UsersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */

class UsersRepository extends \Doctrine\ORM\EntityRepository
{
    public function findById($id) {
        return $this->find($id);
    }

    public function findByName($name) {
        return $this->createQueryBuilder('u')
            ->where('u.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }
    public function add($user) {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        return $user;
    }
}
