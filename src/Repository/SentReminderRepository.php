<?php

namespace App\Repository;

use App\Entity\SentReminder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class SentReminderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SentReminder::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('sr')
            ->select('sr, srr, srro, srru, srrua, srrup')
            ->leftJoin('sr.reminder', 'srr')
            ->leftJoin('sr.routine', 'srro')
            ->leftJoin('srr.user', 'srru')
            ->leftJoin('srru.account', 'srrua')
            ->leftJoin('srru.profile', 'srrup')
            ->addOrderBy('sr.createdAt', 'DESC');

        if (!(empty($parameters))) {
            if (array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('sr.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt);
                }
            }

            if (array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('sr.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt);
                }
            }
        }

        return $queryBuilder->getQuery();
    }
}
