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

    public function findByOptions(array $options = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('q')
            ->select('q')
            ->where('q.deletedAt IS NULL')
            ->addOrderBy('q.createdAt', 'DESC');

        if (!(empty($options))) {
            if (array_key_exists('query', $options)) {
                $query = $options['query'];
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
        }

        return $queryBuilder->getQuery();
    }
}
