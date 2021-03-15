<?php

declare(strict_types=1);

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
            ->select('r, ru, rua, rup, rut, ruuk')
            ->leftJoin('r.user', 'ru')
            ->leftJoin('ru.account', 'rua')
            ->leftJoin('ru.profile', 'rup')
            ->leftJoin('ru.testimonial', 'rut')
            ->leftJoin('ru.userKyt', 'ruuk')
            ->addOrderBy('r.createdAt', 'DESC')
        ;

        if (!(empty($parameters))) {
            if (\array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('r.type = :type')
                        ->setParameter('type', $type)
                    ;
                }
            }

            if (\array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('ru.email', ':q'),
                            $queryBuilder->expr()->like('ru.uuid', ':q')
                        )
                    )
                        ->setParameter('q', sprintf('%%%s%%', $query))
                    ;
                }
            }

            if (\array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('r.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt)
                    ;
                }
            }

            if (\array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('r.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt)
                    ;
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findByParametersForApi(User $user, array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.deletedAt IS NULL')
            ->andWhere('r.user = :user')
            ->addOrderBy('r.name', 'ASC')
            ->setParameter('user', $user)
        ;

        if (!(empty($parameters))) {
            if (\array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('r.type = :type')
                        ->setParameter('type', $type)
                    ;
                }
            }

            if (\array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('r.description', ':q'),
                            $queryBuilder->expr()->like('r.name', ':q')
                        )
                    )
                        ->setParameter('q', sprintf('%%%s%%', $query))
                    ;
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findByParametersForFrontend(User $user, array $parameters = []): array
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r, rcr')
            ->leftJoin('r.completedRoutines', 'rcr')
            ->where('r.deletedAt IS NULL')
            ->andWhere('r.user = :user')
            ->addOrderBy('r.isEnabled', 'DESC')
            ->addOrderBy('r.name', 'ASC')
            ->setParameter('user', $user)
        ;

        if (!(empty($parameters))) {
            if (\array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('r.type = :type')
                        ->setParameter('type', $type)
                    ;
                }
            }

            if (\array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('r.description', ':q'),
                            $queryBuilder->expr()->like('r.name', ':q')
                        )
                    )
                        ->setParameter('q', sprintf('%%%s%%', $query))
                    ;
                }
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
