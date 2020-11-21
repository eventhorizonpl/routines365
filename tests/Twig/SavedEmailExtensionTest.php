<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Tests\AbstractTestCase;
use App\Twig\SavedEmailExtension;

class SavedEmailExtensionTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $savedEmailExtension = new SavedEmailExtension();

        $this->assertInstanceOf(SavedEmailExtension::class, $savedEmailExtension);
    }

    public function testGetFunctions()
    {
        $savedEmailExtension = new SavedEmailExtension();

        $this->assertCount(1, $savedEmailExtension->getFunctions());
        $this->assertIsArray($savedEmailExtension->getFunctions());
    }

    public function testSavedEmailType()
    {
        $savedEmailExtension = new SavedEmailExtension();

        $this->assertCount(2, $savedEmailExtension->savedEmailType());
        $this->assertIsArray($savedEmailExtension->savedEmailType());
    }
}
