<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AccountOperation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class AccountOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountOperation::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('ao')
            ->select('ao, aoa, aoau, aoaup')
            ->leftJoin('ao.account', 'aoa')
            ->leftJoin('aoa.users', 'aoau')
            ->leftJoin('aoau.profile', 'aoaup')
            ->addOrderBy('ao.createdAt', 'DESC')
        ;

        if (!(empty($parameters))) {
            if (\array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('ao.type = :type')
                        ->setParameter('type', $type)
                    ;
                }
            }

            if (\array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('aoau.email', ':q'),
                            $queryBuilder->expr()->like('aoau.uuid', ':q')
                        )
                    )
                        ->setParameter('q', sprintf('%%%s%%', $query))
                    ;
                }
            }

            if (\array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('ao.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt)
                    ;
                }
            }

            if (\array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('ao.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt)
                    ;
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findByParametersForFrontend(User $user, array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('ao')
            ->select('ao, aoa')
            ->leftJoin('ao.account', 'aoa')
            ->where('ao.account = :account')
            ->addOrderBy('ao.createdAt', 'DESC')
            ->setParameter('account', $user->getAccount())
        ;

        if (!(empty($parameters))) {
            if (\array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('ao.type = :type')
                        ->setParameter('type', $type)
                    ;
                }
            }

            if (\array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('ao.description', ':q')
                        )
                    )
                        ->setParameter('q', sprintf('%%%s%%', $query))
                    ;
                }
            }
        }

        return $queryBuilder->getQuery();
    }
}
