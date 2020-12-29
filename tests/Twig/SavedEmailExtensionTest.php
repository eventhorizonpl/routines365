<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\SavedEmailExtension;

final class SavedEmailExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $savedEmailExtension = new SavedEmailExtension();

        $this->assertInstanceOf(SavedEmailExtension::class, $savedEmailExtension);
    }

    public function testGetFunctions(): void
    {
        $savedEmailExtension = new SavedEmailExtension();

        $this->assertCount(1, $savedEmailExtension->getFunctions());
        $this->assertIsArray($savedEmailExtension->getFunctions());
    }

    public function testSavedEmailType(): void
    {
        $savedEmailExtension = new SavedEmailExtension();

        $this->assertCount(2, $savedEmailExtension->savedEmailType());
        $this->assertIsArray($savedEmailExtension->savedEmailType());
    }
}
