<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Enum\UserTypeEnum;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\{PasswordUpgraderInterface, UserInterface};

class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByParametersForAdmin(array $parameters = []): Query
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->select('u, ua, up, ut, uuk')
            ->leftJoin('u.account', 'ua')
            ->leftJoin('u.profile', 'up')
            ->leftJoin('u.testimonial', 'ut')
            ->leftJoin('u.userKyt', 'uuk')
            ->addOrderBy('u.createdAt', 'DESC')
        ;

        if (!(empty($parameters))) {
            if (\array_key_exists('type', $parameters)) {
                $type = $parameters['type'];
                if ((null !== $type) && ('' !== $type)) {
                    $queryBuilder->andWhere('u.type = :type')
                        ->setParameter('type', $type)
                    ;
                }
            }

            if (\array_key_exists('query', $parameters)) {
                $query = $parameters['query'];
                if ((null !== $query) && ('' !== $query)) {
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->like('u.email', ':q'),
                            $queryBuilder->expr()->like('u.referrerCode', ':q'),
                            $queryBuilder->expr()->like('u.uuid', ':q')
                        )
                    )
                        ->setParameter('q', sprintf('%%%s%%', $query))
                    ;
                }
            }

            if (\array_key_exists('ends_at', $parameters)) {
                $endsAt = $parameters['ends_at'];
                if (null !== $endsAt) {
                    $queryBuilder->andWhere('u.createdAt <= :endsAt')
                        ->setParameter('endsAt', $endsAt)
                    ;
                }
            }

            if (\array_key_exists('starts_at', $parameters)) {
                $startsAt = $parameters['starts_at'];
                if (null !== $startsAt) {
                    $queryBuilder->andWhere('u.createdAt >= :startsAt')
                        ->setParameter('startsAt', $startsAt)
                    ;
                }
            }
        }

        return $queryBuilder->getQuery();
    }

    public function findForKpi(): Query
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->select('u, ua, up')
            ->leftJoin('u.account', 'ua')
            ->leftJoin('u.profile', 'up')
            ->where('u.deletedAt IS NULL')
            ->andWhere('u.isEnabled = :isEnabled')
            ->andWhere('u.isVerified = :isVerified')
            ->andWhere('up.sendWeeklyMonthlyStatistics = :sendWeeklyMonthlyStatistics')
            ->addOrderBy('u.createdAt', 'DESC')
            ->setParameter('isEnabled', true)
            ->setParameter('isVerified', true)
            ->setParameter('sendWeeklyMonthlyStatistics', true)
        ;

        return $queryBuilder->getQuery();
    }

    public function findForPostUserKytMessages(): Query
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->select('u, up, uuk')
            ->leftJoin('u.profile', 'up')
            ->leftJoin('u.userKyt', 'uuk')
            ->where('u.deletedAt IS NULL')
            ->andWhere('u.isEnabled = :isEnabled')
            ->andWhere('u.isVerified = :isVerified')
            ->addOrderBy('u.id', 'ASC')
            ->setParameter('isEnabled', true)
            ->setParameter('isVerified', true)
        ;

        return $queryBuilder->getQuery();
    }

    public function findForRetention(DateTimeImmutable $endDate, DateTimeImmutable $lastLoginAt, DateTimeImmutable $startDate): int
    {
        $query = $this->_em->createQuery(sprintf(
            'SELECT COUNT(u.id) FROM %s u WHERE u.createdAt <= :endDate AND u.createdAt >= :startDate AND u.lastLoginAt >= :lastLoginAt',
            User::class
        ))
            ->setParameter('endDate', $endDate)
            ->setParameter('lastLoginAt', $lastLoginAt)
            ->setParameter('startDate', $startDate)
        ;

        return (int) $query->getSingleScalarResult();
    }

    public function findForRetentionTotal(DateTimeImmutable $endDate, DateTimeImmutable $startDate): int
    {
        $query = $this->_em->createQuery(sprintf(
            'SELECT COUNT(u.id) FROM %s u WHERE u.createdAt <= :endDate AND u.createdAt >= :startDate',
            User::class
        ))
            ->setParameter('endDate', $endDate)
            ->setParameter('startDate', $startDate)
        ;

        return (int) $query->getSingleScalarResult();
    }

    public function findForRewardUserActivity(DateTimeImmutable $lastActivityAt): Query
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->select('u, ua, up')
            ->leftJoin('u.account', 'ua')
            ->leftJoin('u.profile', 'up')
            ->where('u.deletedAt IS NULL')
            ->andWhere('u.isEnabled = :isEnabled')
            ->andWhere('u.isVerified = :isVerified')
            ->andWhere('u.type = :type')
            ->andWhere('u.lastActivityAt >= :lastActivityAt')
            ->addOrderBy('u.createdAt', 'DESC')
            ->setParameter('isEnabled', true)
            ->setParameter('isVerified', true)
            ->setParameter('lastActivityAt', $lastActivityAt)
            ->setParameter('type', UserTypeEnum::PROSPECT->value)
        ;

        return $queryBuilder->getQuery();
    }

    public function findOneByEmail(string $email): ?User
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->andWhere('u.deletedAt IS NULL')
            ->andWhere('u.isEnabled = :isEnabled')
            ->setParameter('email', $email)
            ->setParameter('isEnabled', true)
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
