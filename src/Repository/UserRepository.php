<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->select('u, ua, up')
            ->leftJoin('u.account', 'ua')
            ->leftJoin('u.profile', 'up')
            ->addOrderBy('u.createdAt', 'DESC');

        if (!(empty($parameters))) {
            if (array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('u.email', ':q')
                        )
                    )
                    ->setParameter('q', '%'.$query.'%');
                }
            }

            if (array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('u.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt);
                }
            }

            if (array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('u.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt);
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
