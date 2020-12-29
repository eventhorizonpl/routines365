<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Profile;
use App\Factory\ProfileFactory;
use App\Tests\AbstractTestCase;

final class ProfileFactoryTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $profileFactory = new ProfileFactory();

        $this->assertInstanceOf(ProfileFactory::class, $profileFactory);
    }

    public function testCreateProfile(): void
    {
        $profileFactory = new ProfileFactory();
        $profile = $profileFactory->createProfile();
        $this->assertInstanceOf(Profile::class, $profile);
    }
}
