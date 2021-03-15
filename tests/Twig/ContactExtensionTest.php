<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\ContactExtension;

/**
 * @internal
 * @coversNothing
 */
final class ContactExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $contactExtension = new ContactExtension();

        $this->assertInstanceOf(ContactExtension::class, $contactExtension);
    }

    public function testGetFunctions(): void
    {
        $contactExtension = new ContactExtension();

        $this->assertCount(2, $contactExtension->getFunctions());
        $this->assertIsArray($contactExtension->getFunctions());
    }

    public function testContactStatus(): void
    {
        $contactExtension = new ContactExtension();

        $this->assertCount(6, $contactExtension->contactStatus());
        $this->assertIsArray($contactExtension->contactStatus());
    }

    public function testContactType(): void
    {
        $contactExtension = new ContactExtension();

        $this->assertCount(2, $contactExtension->contactType());
        $this->assertIsArray($contactExtension->contactType());
    }
}
