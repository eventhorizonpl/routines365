<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Achievement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class AchievementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Achievement::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->select('a')
            ->addOrderBy('a.createdAt', 'DESC');

        if (!(empty($parameters))) {
            if (array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('a.type = :type')
                        ->setParameter('type', $type);
                }
            }

            if (array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('a.description', ':q'),
                            $queryBuilder->expr()->like('a.name', ':q')
                        )
                    )
                    ->setParameter('q', sprintf('%%%s%%', $query));
                }
            }

            if (array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('a.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt);
                }
            }

            if (array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('a.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt);
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findByRequirementAndType($requirement, $type): array
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.deletedAt IS NULL')
            ->andWhere('a.isEnabled = :isEnabled')
            ->andWhere('a.requirement  <= :requirement')
            ->andWhere('a.type  = :type')
            ->orderBy('a.level', 'ASC')
            ->setParameter('isEnabled', true)
            ->setParameter('requirement', $requirement)
            ->setParameter('type', $type);

        return $queryBuilder->getQuery()->getResult();
    }

    public function findForFrontend(): array
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->select('a')
            ->addOrderBy('a.type', 'ASC')
            ->addOrderBy('a.level', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }
}
