<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Tests\AbstractTestCase;
use App\Util\DateTimeImmutableUtil;
use DateTimeImmutable;

final class DateTimeImmutableUtilTest extends AbstractTestCase
{
    public function testDateFromString(): void
    {
        $endsAt = '2020-01-01';
        $result = DateTimeImmutableUtil::dateFromString($endsAt);
        $this->assertInstanceOf(DateTimeImmutable::class, $result);
        $this->assertEquals($endsAt, $result->format('Y-m-d'));
        $this->assertEquals('00:00:00', $result->format('H:i:s'));
        $endsAt = '';
        $result = DateTimeImmutableUtil::dateFromString($endsAt);
        $this->assertEquals(null, $result);
        $endsAt = null;
        $result = DateTimeImmutableUtil::dateFromString($endsAt);
        $this->assertEquals(null, $result);
        $endsAt = 'something wrong';
        $result = DateTimeImmutableUtil::dateFromString($endsAt);
        $this->assertEquals(null, $result);
    }

    public function testEndsAtFromString(): void
    {
        $endsAt = '2020-01-01';
        $result = DateTimeImmutableUtil::endsAtFromString($endsAt);
        $this->assertInstanceOf(DateTimeImmutable::class, $result);
        $this->assertEquals($endsAt, $result->format('Y-m-d'));
        $this->assertEquals('23:59:59', $result->format('H:i:s'));
        $endsAt = '';
        $result = DateTimeImmutableUtil::endsAtFromString($endsAt);
        $this->assertEquals(null, $result);
        $endsAt = null;
        $result = DateTimeImmutableUtil::endsAtFromString($endsAt);
        $this->assertEquals(null, $result);
        $endsAt = 'something wrong';
        $result = DateTimeImmutableUtil::endsAtFromString($endsAt);
        $this->assertEquals(null, $result);
    }

    public function testStartsAtFromString(): void
    {
        $startsAt = '2020-01-01';
        $result = DateTimeImmutableUtil::startsAtFromString($startsAt);
        $this->assertInstanceOf(DateTimeImmutable::class, $result);
        $this->assertEquals($startsAt, $result->format('Y-m-d'));
        $this->assertEquals('00:00:00', $result->format('H:i:s'));
        $startsAt = '';
        $result = DateTimeImmutableUtil::startsAtFromString($startsAt);
        $this->assertEquals(null, $result);
        $startsAt = null;
        $result = DateTimeImmutableUtil::startsAtFromString($startsAt);
        $this->assertEquals(null, $result);
        $startsAt = 'something wrong';
        $result = DateTimeImmutableUtil::startsAtFromString($startsAt);
        $this->assertEquals(null, $result);
    }
}
