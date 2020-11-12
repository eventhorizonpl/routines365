<?php

declare(strict_types=1);

namespace App\Util;

use DateTime;
use DateTimeImmutable;
use Exception;

class DateTimeImmutableUtil
{
    public static function endsAtFromString(?string $endsAt): ?DateTimeImmutable
    {
        if ((null !== $endsAt) && ('' !== $endsAt)) {
            try {
                $dateTime = new DateTime(trim($endsAt));
            } catch (Exception $e) {
                return null;
            }
            $dateTime->setTime(23, 59, 59);

            return DateTimeImmutable::createFromMutable($dateTime);
        }

        return null;
    }

    public static function startsAtFromString(?string $startsAt): ?DateTimeImmutable
    {
        if ((null !== $startsAt) && ('' !== $startsAt)) {
            try {
                $dateTime = new DateTime(trim($startsAt));
            } catch (Exception $e) {
                return null;
            }
            $dateTime->setTime(0, 0, 0);

            return DateTimeImmutable::createFromMutable($dateTime);
        }

        return null;
    }
}
