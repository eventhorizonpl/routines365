<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Retention;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class RetentionFactory
{
    public function createRetention(): Retention
    {
        $retention = new Retention();
        $retention->setUuid((string) Uuid::v4());

        return $retention;
    }

    public function createRetentionWithRequired(
        array $data,
        DateTimeImmutable $date
    ): Retention {
        $retention = $this->createRetention();

        $retention
            ->setData($data)
            ->setDate($date);

        return $retention;
    }
}
