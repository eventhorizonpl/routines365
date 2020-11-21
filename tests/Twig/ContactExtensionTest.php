<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Tests\AbstractTestCase;
use App\Twig\ContactExtension;

class ContactExtensionTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $contactExtension = new ContactExtension();

        $this->assertInstanceOf(ContactExtension::class, $contactExtension);
    }

    public function testGetFunctions()
    {
        $contactExtension = new ContactExtension();

        $this->assertCount(2, $contactExtension->getFunctions());
        $this->assertIsArray($contactExtension->getFunctions());
    }

    public function testContactStatus()
    {
        $contactExtension = new ContactExtension();

        $this->assertCount(6, $contactExtension->contactStatus());
        $this->assertIsArray($contactExtension->contactStatus());
    }

    public function testContactType()
    {
        $contactExtension = new ContactExtension();

        $this->assertCount(2, $contactExtension->contactType());
        $this->assertIsArray($contactExtension->contactType());
    }
}
