<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;

abstract class AbstractCommandTestCase extends AbstractKernelTestCase
{
    protected ?Application $application;

    protected function setUp(): void
    {
        parent::setUp();

        $this->application = new Application(self::$kernel);
    }

    protected function tearDown(): void
    {
        unset($this->application);

        parent::tearDown();
    }
}
