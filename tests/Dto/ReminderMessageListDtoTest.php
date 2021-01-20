<?php

declare(strict_types=1);

namespace App\Tests\Dto;

use App\Dto\ReminderMessageListDto;
use App\Tests\AbstractTestCase;

final class ReminderMessageListDtoTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $code = 100;
        $data = ['test'];
        $status = 'success';
        $reminderMessageListDto = new ReminderMessageListDto($code, $data);
        $this->assertInstanceOf(ReminderMessageListDto::class, $reminderMessageListDto);
        $this->assertEquals($code, $reminderMessageListDto->code);
        $this->assertEquals($data, $reminderMessageListDto->data);
        $this->assertEquals($status, $reminderMessageListDto->status);
        $status = 'error';
        $reminderMessageListDto = new ReminderMessageListDto($code, $data, $status);
        $this->assertEquals($status, $reminderMessageListDto->status);
    }
}
