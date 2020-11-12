<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\SavedEmail;
use Symfony\Component\Uid\Uuid;

class SavedEmailFactory
{
    public function createSavedEmail(): SavedEmail
    {
        $savedEmail = new SavedEmail();
        $savedEmail->setUuid(Uuid::v4());

        return $savedEmail;
    }

    public function createSavedEmailWithRequired(
        string $email,
        string $type
    ): SavedEmail {
        $savedEmail = $this->createSavedEmail();

        $savedEmail
            ->setEmail($email)
            ->setType($type);

        return $savedEmail;
    }
}
