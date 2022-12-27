<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // https://symfony.com/doc/current/security/user_providers.html#using-a-custom-query-to-load-the-user
    public function loadUserByIdentifier(string $usernameOrEmail): ?User
    {
        $entityManager = $this->getEntityManager();

        return $entityManager
            ->createQuery(
                'SELECT u
                    FROM App\Entity\User u
                    WHERE lower(u.email) = lower(:email)'
            )
            ->setParameter('email', $usernameOrEmail)
            ->getOneOrNullResult()
        ;
    }
}
