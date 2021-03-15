<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Tests\AbstractTestCase;
use App\Util\DateTimeImmutableUtil;
use DateTimeImmutable;

/**
 * @internal
 * @coversNothing
 */
final class DateTimeImmutableUtilTest extends AbstractTestCase
{
    public function testDateFromString(): void
    {
        $endsAt = '2020-01-01';
        $result = DateTimeImmutableUtil::dateFromString($endsAt);
        $this->assertInstanceOf(DateTimeImmutable::class, $result);
        $this->assertSame($endsAt, $result->format('Y-m-d'));
        $this->assertSame('00:00:00', $result->format('H:i:s'));
        $endsAt = '';
        $result = DateTimeImmutableUtil::dateFromString($endsAt);
        $this->assertNull($result);
        $endsAt = null;
        $result = DateTimeImmutableUtil::dateFromString($endsAt);
        $this->assertNull($result);
        $endsAt = 'something wrong';
        $result = DateTimeImmutableUtil::dateFromString($endsAt);
        $this->assertNull($result);
    }

    public function testEndsAtFromString(): void
    {
        $endsAt = '2020-01-01';
        $result = DateTimeImmutableUtil::endsAtFromString($endsAt);
        $this->assertInstanceOf(DateTimeImmutable::class, $result);
        $this->assertSame($endsAt, $result->format('Y-m-d'));
        $this->assertSame('23:59:59', $result->format('H:i:s'));
        $endsAt = '';
        $result = DateTimeImmutableUtil::endsAtFromString($endsAt);
        $this->assertNull($result);
        $endsAt = null;
        $result = DateTimeImmutableUtil::endsAtFromString($endsAt);
        $this->assertNull($result);
        $endsAt = 'something wrong';
        $result = DateTimeImmutableUtil::endsAtFromString($endsAt);
        $this->assertNull($result);
    }

    public function testStartsAtFromString(): void
    {
        $startsAt = '2020-01-01';
        $result = DateTimeImmutableUtil::startsAtFromString($startsAt);
        $this->assertInstanceOf(DateTimeImmutable::class, $result);
        $this->assertSame($startsAt, $result->format('Y-m-d'));
        $this->assertSame('00:00:00', $result->format('H:i:s'));
        $startsAt = '';
        $result = DateTimeImmutableUtil::startsAtFromString($startsAt);
        $this->assertNull($result);
        $startsAt = null;
        $result = DateTimeImmutableUtil::startsAtFromString($startsAt);
        $this->assertNull($result);
        $startsAt = 'something wrong';
        $result = DateTimeImmutableUtil::startsAtFromString($startsAt);
        $this->assertNull($result);
    }
}
