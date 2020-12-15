<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Promotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class PromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->select('p')
            ->addOrderBy('p.createdAt', 'DESC');

        if (!(empty($parameters))) {
            if (array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('p.type = :type')
                        ->setParameter('type', $type);
                }
            }

            if (array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('p.code', ':q'),
                            $queryBuilder->expr()->like('p.description', ':q'),
                            $queryBuilder->expr()->like('p.name', ':q')
                        )
                    )
                    ->setParameter('q', '%'.$query.'%');
                }
            }

            if (array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('p.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt);
                }
            }

            if (array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('p.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt);
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findOneByCodeAndType(string $code, string $type): ?Promotion
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.deletedAt IS NULL')
            ->andWhere('p.isEnabled = :isEnabled')
            ->andWhere('p.code = :code')
            ->andWhere('p.type = :type')
            ->setMaxResults(1)
            ->setParameter('isEnabled', true)
            ->setParameter('code', $code)
            ->setParameter('type', $type);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
