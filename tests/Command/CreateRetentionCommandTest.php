<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Tests\AbstractCommandTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @internal
 * @coversNothing
 */
final class CreateRetentionCommandTest extends AbstractCommandTestCase
{
    public function testExecute(): void
    {
        $command = $this->application->find('app:create-retention');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $this->assertSame('', $output);
    }
}
