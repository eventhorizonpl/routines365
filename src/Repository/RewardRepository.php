<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Reward;
use App\Entity\Routine;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class RewardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reward::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r, ru, rua, rup')
            ->leftJoin('r.user', 'ru')
            ->leftJoin('ru.account', 'rua')
            ->leftJoin('ru.profile', 'rup')
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

            if (array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('r.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt);
                }
            }

            if (array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('r.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt);
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findByParametersForFrontend(User $user, array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r, rr')
            ->leftJoin('r.routine', 'rr')
            ->where('r.deletedAt IS NULL')
            ->andWhere('r.user = :user')
            ->addOrderBy('r.createdAt', 'DESC')
            ->setParameter('user', $user);

        if (!(empty($parameters))) {
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

        return $queryBuilder->getQuery();
    }

    public function findOneByUserAndTypesAndRoutine(User $user, array $types, Routine $routine = null): ?Reward
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.deletedAt IS NULL')
            ->andWhere('r.user = :user')
            ->andWhere('r.isAwarded = :isAwarded')
            ->andWhere('r.type IN (:types)')
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(1)
            ->setParameter('isAwarded', false)
            ->setParameter('types', $types)
            ->setParameter('user', $user);

        if (null !== $routine) {
            $queryBuilder->andWhere('r.routine = :routine')
                ->setParameter('routine', $routine);
        }

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
