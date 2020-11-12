<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Profile;
use Symfony\Component\Uid\Uuid;

class ProfileFactory
{
    public function createProfile(): Profile
    {
        $profile = new Profile();
        $profile->setUuid(Uuid::v4());

        return $profile;
    }
}
