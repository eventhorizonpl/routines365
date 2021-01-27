<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ReminderMessage;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class ReminderMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReminderMessage::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('rm')
            ->select('rm, rmr, rmru, rmrua, rmrup, rmrut, rmruuk')
            ->leftJoin('rm.reminder', 'rmr')
            ->leftJoin('rmr.user', 'rmru')
            ->leftJoin('rmru.account', 'rmrua')
            ->leftJoin('rmru.profile', 'rmrup')
            ->leftJoin('rmru.testimonial', 'rmrut')
            ->leftJoin('rmru.userKyt', 'rmruuk')
            ->addOrderBy('rm.createdAt', 'DESC');

        if (!(empty($parameters))) {
            if (array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('rm.type = :type')
                        ->setParameter('type', $type);
                }
            }

            if (array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('rm.content', ':q'),
                            $queryBuilder->expr()->like('rmru.email', ':q'),
                            $queryBuilder->expr()->like('rmru.uuid', ':q')
                        )
                    )
                    ->setParameter('q', sprintf('%%%s%%', $query));
                }
            }

            if (array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('rm.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt);
                }
            }

            if (array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('rm.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt);
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findByRemindersAndPostDateAndType(
        ArrayCollection $reminders,
        DateTimeImmutable $postDate,
        string $type
    ): array {
        if (0 === count($reminders)) {
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('rm')
            ->select('rm')
            ->where('rm.reminder IN (:reminders)')
            ->andWhere('rm.type = :type')
            ->andWhere('rm.isReadFromBrowser = :isReadFromBrowser')
            ->andWhere('rm.postDate >= :postDate')
            ->addOrderBy('rm.createdAt', 'DESC')
            ->setParameter('postDate', $postDate)
            ->setParameter('reminders', $reminders)
            ->setParameter('type', $type)
            ->setParameter('isReadFromBrowser', false);

        return $queryBuilder->getQuery()->getResult();
    }
}
