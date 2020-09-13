<?php

namespace App\Repository;

use App\Entity\Quote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class QuoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quote::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('q')
            ->select('q')
            ->addOrderBy('q.createdAt', 'DESC');

        if (!(empty($parameters))) {
            if (array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('q.author', ':q'),
                            $queryBuilder->expr()->like('q.content', ':q')
                        )
                    )
                    ->setParameter('q', '%'.$query.'%');
                }
            }

            if (array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('q.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt);
                }
            }

            if (array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('q.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt);
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findOneByStringLength(int $stringLength = null): ?Quote
    {
        $queryBuilder = $this->createQueryBuilder('q')
            ->where('q.deletedAt IS NULL')
            ->orderBy('RAND()')
            ->setMaxResults(1);

        if (null !== $stringLength) {
            $queryBuilder->andWhere('q.stringLength <= :stringLength')
                ->setParameter('stringLength', $stringLength);
        }

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
