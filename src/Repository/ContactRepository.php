<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('c, cu, cua, cup')
            ->leftJoin('c.user', 'cu')
            ->leftJoin('cu.account', 'cua')
            ->leftJoin('cu.profile', 'cup')
            ->addOrderBy('c.createdAt', 'DESC');

        if (!(empty($parameters))) {
            if (array_key_exists('status', $parameters)) {
                $status = $parameters['status'];
                if ((null !== $status) && ('' !== $status)) {
                    $queryBuilder->andWhere('c.status = :status')
                        ->setParameter('status', $status);
                }
            }

            if (array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('c.type = :type')
                        ->setParameter('type', $type);
                }
            }

            if (array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('cu.email', ':q'),
                            $queryBuilder->expr()->like('cu.uuid', ':q')
                        )
                    )
                    ->setParameter('q', sprintf('%%%s%%', $query));
                }
            }

            if (array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('c.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt);
                }
            }

            if (array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('c.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt);
                }
            }
        }

        return $queryBuilder->getQuery();
    }
}
