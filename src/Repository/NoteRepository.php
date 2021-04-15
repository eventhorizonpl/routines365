<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\{Note, User};
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('n')
            ->select('n, nu, nua, nup, nut, nuuk')
            ->leftJoin('n.user', 'nu')
            ->leftJoin('nu.account', 'nua')
            ->leftJoin('nu.profile', 'nup')
            ->leftJoin('nu.testimonial', 'nut')
            ->leftJoin('nu.userKyt', 'nuuk')
            ->addOrderBy('n.createdAt', 'DESC')
        ;

        if (!(empty($parameters))) {
            if (\array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('nu.email', ':q'),
                            $queryBuilder->expr()->like('nu.uuid', ':q')
                        )
                    )
                        ->setParameter('q', sprintf('%%%s%%', $query))
                    ;
                }
            }

            if (\array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('n.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt)
                    ;
                }
            }

            if (\array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('n.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt)
                    ;
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findByParametersForFrontend(User $user, array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('n')
            ->select('n, nr')
            ->leftJoin('n.routine', 'nr')
            ->where('n.deletedAt IS NULL')
            ->andWhere('n.user = :user')
            ->addOrderBy('n.createdAt', 'DESC')
            ->setParameter('user', $user)
        ;

        if (!(empty($parameters))) {
            if (\array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('n.content', ':q'),
                            $queryBuilder->expr()->like('n.title', ':q')
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
