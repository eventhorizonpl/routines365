<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Testimonial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class TestimonialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Testimonial::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select('t, tu, tua, tup')
            ->leftJoin('t.user', 'tu')
            ->leftJoin('tu.account', 'tua')
            ->leftJoin('tu.profile', 'tup')
            ->addOrderBy('t.createdAt', 'DESC');

        if (!(empty($parameters))) {
            if (array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('tu.email', ':q'),
                            $queryBuilder->expr()->like('tu.uuid', ':q')
                        )
                    )
                    ->setParameter('q', sprintf('%%%s%%', $query));
                }
            }

            if (array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('t.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt);
                }
            }

            if (array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('t.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt);
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findOneRand(): ?Testimonial
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->where('t.deletedAt IS NULL')
            ->andWhere('t.isVisible = :isVisible')
            ->andWhere('t.status = :status')
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ->setParameter('isVisible', true)
            ->setParameter('status', Testimonial::STATUS_ACCEPTED);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
