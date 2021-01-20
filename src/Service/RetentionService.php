<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Retention;
use App\Factory\RetentionFactory;
use App\Manager\RetentionManager;
use App\Repository\RetentionRepository;
use App\Repository\UserRepository;
use App\Util\DateTimeImmutableUtil;
use DateTime;
use DateTimeImmutable;

class RetentionService
{
    private RetentionFactory $retentionFactory;
    private RetentionManager $retentionManager;
    private RetentionRepository $retentionRepository;
    private UserRepository $userRepository;

    public function __construct(
        RetentionFactory $retentionFactory,
        RetentionManager $retentionManager,
        RetentionRepository $retentionRepository,
        UserRepository $userRepository
    ) {
        $this->retentionFactory = $retentionFactory;
        $this->retentionManager = $retentionManager;
        $this->retentionRepository = $retentionRepository;
        $this->userRepository = $userRepository;
    }

    public function create(
        array $data,
        DateTimeImmutable $date
    ): Retention {
        $retention = $this->retentionFactory->createRetentionWithRequired(
            $data,
            $date
        );

        return $retention;
    }

    public function findOrCreate(
        array $data,
        DateTimeImmutable $date
    ): Retention {
        $retention = $this->retentionRepository->findOneBy([
            'date' => $date,
        ]);

        if (null === $retention) {
            $retention = $this->create(
                $data,
                $date
            );
        } else {
            $retention->setData($data);
        }

        $this->retentionManager->save($retention);

        return $retention;
    }

    public function run(?string $today = null): RetentionService
    {
        $startDate = new DateTime('2020-10-01');
        $startDate->setTime(0, 0, 0);
        $pointerTime = clone $startDate;
        if (null === $today) {
            $today = new DateTimeImmutable();
        } else {
            $today = DateTimeImmutableUtil::dateFromString($today);
        }
        $endDate = $this->getEndDate($startDate);

        $data = [];

        while ($endDate <= $today) {
            $usersCountMonth = $this->userRepository->findForRetention(
                $endDate,
                DateTimeImmutable::createFromMutable($pointerTime),
                DateTimeImmutable::createFromMutable($pointerTime)
            );

            $usersCountActive = $this->userRepository->findForRetention(
                $endDate,
                DateTimeImmutable::createFromMutable($pointerTime),
                DateTimeImmutable::createFromMutable($startDate)
            );
            $usersCountAll = $this->userRepository->findForRetentionTotal($endDate, DateTimeImmutable::createFromMutable($startDate));
            $usersCountThisMonth = $this->userRepository->findForRetentionTotal($endDate, DateTimeImmutable::createFromMutable($pointerTime));

            $data[$endDate->format('Y-m')] = [
                'count' => $usersCountMonth,
                'newCustomers' => $usersCountThisMonth,
                'percent' => ($usersCountAll > 0) ? (($usersCountActive / $usersCountAll) * 100) : 0,
            ];
            $pointerTime->modify('+1 month');
            $endDate = $this->getEndDate($pointerTime);
        }

        $this->findOrCreate(
            $data,
            $endDate
        );

        return $this;
    }

    public function getEndDate(DateTime $pointerTime): DateTimeImmutable
    {
        $dateTime = clone $pointerTime;
        $dateTime->modify('+1 month');
        $dateTime->modify('-1 second');

        return DateTimeImmutable::createFromMutable($dateTime);
    }
}
