<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\UserKyt;
use Symfony\Component\Uid\Uuid;

class UserKytFactory
{
    public function createUserKyt(): UserKyt
    {
        $userKyt = new UserKyt();
        $userKyt->setUuid((string) Uuid::v4());

        return $userKyt;
    }
}
