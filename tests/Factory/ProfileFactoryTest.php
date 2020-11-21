<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Entity\Profile;
use App\Factory\ProfileFactory;
use App\Tests\AbstractTestCase;

class ProfileFactoryTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $profileFactory = new ProfileFactory();

        $this->assertInstanceOf(ProfileFactory::class, $profileFactory);
    }

    public function testCreateProfile()
    {
        $profileFactory = new ProfileFactory();
        $profile = $profileFactory->createProfile();
        $this->assertInstanceOf(Profile::class, $profile);
    }
}
