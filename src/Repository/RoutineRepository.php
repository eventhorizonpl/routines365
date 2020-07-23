<?php

namespace App\Repository;

use App\Entity\Routine;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class RoutineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Routine::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r, ru')
            ->leftJoin('r.user', 'ru')
            ->where('r.deletedAt IS NULL')
            ->addOrderBy('r.createdAt', 'DESC');

        if (!(empty($parameters))) {
            if (array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('r.type = :type')
                        ->setParameter('type', $type);
                }
            }

            if (array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('ru.email', ':q'),
                            $queryBuilder->expr()->like('ru.uuid', ':q')
                        )
                    )
                    ->setParameter('q', '%'.$query.'%');
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findByParametersForFrontend(User $user, array $parameters = []): array
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.deletedAt IS NULL')
            ->andWhere('r.user = :user')
            ->addOrderBy('r.isEnabled', 'DESC')
            ->addOrderBy('r.name', 'ASC')
            ->setParameter('user', $user);

        if (!(empty($parameters))) {
            if (array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('r.type = :type')
                        ->setParameter('type', $type);
                }
            }

            if (array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('r.description', ':q'),
                            $queryBuilder->expr()->like('r.name', ':q')
                        )
                    )
                    ->setParameter('q', '%'.$query.'%');
                }
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
