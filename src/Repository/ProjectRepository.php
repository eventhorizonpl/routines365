<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->select('p, pu, pua, pup, put, puuk')
            ->leftJoin('p.user', 'pu')
            ->leftJoin('pu.account', 'pua')
            ->leftJoin('pu.profile', 'pup')
            ->leftJoin('pu.testimonial', 'put')
            ->leftJoin('pu.userKyt', 'puuk')
            ->addOrderBy('p.createdAt', 'DESC')
        ;

        if (!(empty($parameters))) {
            if (\array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('pu.email', ':q'),
                            $queryBuilder->expr()->like('pu.uuid', ':q')
                        )
                    )
                        ->setParameter('q', sprintf('%%%s%%', $query))
                    ;
                }
            }

            if (\array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('p.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt)
                    ;
                }
            }

            if (\array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('p.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt)
                    ;
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findByParametersForFrontend(User $user, array $parameters = []): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->select('p, pg')
            ->leftJoin('p.goals', 'pg')
            ->where('p.deletedAt IS NULL')
            ->andWhere('p.user = :user')
            ->addOrderBy('p.name', 'ASC')
            ->setParameter('user', $user)
        ;

        if (!(empty($parameters))) {
            if (\array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('p.description', ':q'),
                            $queryBuilder->expr()->like('p.name', ':q')
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
