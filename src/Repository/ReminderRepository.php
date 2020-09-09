<?php

namespace App\Repository;

use App\Entity\Reminder;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class ReminderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reminder::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r, ru, rua, rup')
            ->leftJoin('r.user', 'ru')
            ->leftJoin('ru.account', 'rua')
            ->leftJoin('ru.profile', 'rup')
            ->addOrderBy('r.createdAt', 'DESC');

        if (!(empty($parameters))) {
            if (array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('r.type = :type')
                        ->setParameter('type', $type);
                }
            }

            if (array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('ru.email', ':q'),
                            $queryBuilder->expr()->like('ru.uuid', ':q')
                        )
                    )
                    ->setParameter('q', '%'.$query.'%');
                }
            }

            if (array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('r.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt);
                }
            }

            if (array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('r.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt);
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findOneByNextDate(DateTimeImmutable $nextDate): ?Reminder
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r, rr, rrg, ru, rup')
            ->leftJoin('r.routine', 'rr')
            ->leftJoin('rr.goals', 'rrg')
            ->leftJoin('r.user', 'ru')
            ->leftJoin('ru.profile', 'rup')
            ->where('r.deletedAt IS NULL')
            ->andWhere('r.lockedAt IS NULL')
            ->andWhere('r.nextDate < :nextDate')
            ->andWhere('r.isEnabled = :isEnabled')
            ->andWhere('rr.isEnabled = :isEnabled')
            ->orderBy('r.nextDate', 'ASC')
            ->setMaxResults(1)
            ->setParameter('isEnabled', true)
            ->setParameter('nextDate', $nextDate);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
