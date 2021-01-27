<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserKpi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class UserKpiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserKpi::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('uk')
            ->select('uk, uku, ukua, ukup, ukut, ukuuk')
            ->leftJoin('uk.user', 'uku')
            ->leftJoin('uku.account', 'ukua')
            ->leftJoin('uku.profile', 'ukup')
            ->leftJoin('uku.testimonial', 'ukut')
            ->leftJoin('uku.userKyt', 'ukuuk')
            ->addOrderBy('uk.createdAt', 'DESC');

        if (!(empty($parameters))) {
            if (array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('uk.type = :type')
                        ->setParameter('type', $type);
                }
            }

            if (array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('uku.email', ':q'),
                            $queryBuilder->expr()->like('uku.uuid', ':q')
                        )
                    )
                    ->setParameter('q', sprintf('%%%s%%', $query));
                }
            }

            if (array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('uk.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt);
                }
            }

            if (array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('uk.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt);
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findOneByTypeAndUser(string $type, User $user): ?UserKpi
    {
        $queryBuilder = $this->createQueryBuilder('uk')
            ->where('uk.type = :type')
            ->andWhere('uk.user = :user')
            ->orderBy('uk.date', 'DESC')
            ->setMaxResults(1)
            ->setParameter('type', $type)
            ->setParameter('user', $user);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
