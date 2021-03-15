<?php

declare(strict_types=1);

namespace App\Tests\Dto;

use App\Dto\ReminderMessageListDto;
use App\Tests\AbstractTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ReminderMessageListDtoTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $code = 100;
        $data = ['test'];
        $status = 'success';
        $reminderMessageListDto = new ReminderMessageListDto($code, $data);
        $this->assertInstanceOf(ReminderMessageListDto::class, $reminderMessageListDto);
        $this->assertSame($code, $reminderMessageListDto->code);
        $this->assertSame($data, $reminderMessageListDto->data);
        $this->assertSame($status, $reminderMessageListDto->status);
        $status = 'error';
        $reminderMessageListDto = new ReminderMessageListDto($code, $data, $status);
        $this->assertSame($status, $reminderMessageListDto->status);
    }
}
