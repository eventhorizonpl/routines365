<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CompletedRoutine;
use App\Entity\Routine;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class CompletedRoutineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompletedRoutine::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('cr')
            ->select('cr, cru, crua, crup, crut, cruuk')
            ->leftJoin('cr.user', 'cru')
            ->leftJoin('cru.account', 'crua')
            ->leftJoin('cru.profile', 'crup')
            ->leftJoin('cru.testimonial', 'crut')
            ->leftJoin('cru.userKyt', 'cruuk')
            ->addOrderBy('cr.createdAt', 'DESC')
        ;

        if (!(empty($parameters))) {
            if (\array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('cru.email', ':q'),
                            $queryBuilder->expr()->like('cru.uuid', ':q')
                        )
                    )
                        ->setParameter('q', sprintf('%%%s%%', $query))
                    ;
                }
            }

            if (\array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('cr.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt)
                    ;
                }
            }

            if (\array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('cr.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt)
                    ;
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findByParametersForApi(User $user, Routine $routine): Query
    {
        $queryBuilder = $this->createQueryBuilder('cr')
            ->select('cr')
            ->where('cr.deletedAt IS NULL')
            ->andWhere('cr.routine = :routine')
            ->andWhere('cr.user = :user')
            ->addOrderBy('cr.createdAt', 'DESC')
            ->setParameter('routine', $routine)
            ->setParameter('user', $user)
        ;

        return $queryBuilder->getQuery();
    }
}
