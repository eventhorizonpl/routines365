<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\{SavedEmail, User};
use App\Factory\SavedEmailFactory;
use App\Manager\SavedEmailManager;

class SavedEmailService
{
    public function __construct(
        private SavedEmailFactory $savedEmailFactory,
        private SavedEmailManager $savedEmailManager
    ) {
    }

    public function create(
        string $email,
        string $type,
        User $user
    ): SavedEmail {
        $savedEmail = $this->savedEmailFactory->createSavedEmailWithRequired(
            $email,
            $type
        );
        $savedEmail->setUser($user);
        $this->savedEmailManager->save($savedEmail);

        return $savedEmail;
    }
}
