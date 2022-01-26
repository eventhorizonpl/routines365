<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\SavedEmail;
use App\Enum\SavedEmailTypeEnum;
use App\Factory\SavedEmailFactory;
use Faker\{Factory, Generator};

class SavedEmailFaker
{
    private Generator $faker;

    public function __construct(
        private SavedEmailFactory $savedEmailFactory
    ) {
        $this->faker = Factory::create();
    }

    public function createSavedEmail(
        ?string $email = null,
        ?SavedEmailTypeEnum $type = null
    ): SavedEmail {
        if (null === $email) {
            $email = (string) $this->faker->safeEmail();
        }

        if (null === $type) {
            $type = SavedEmailTypeEnum::INVITATION;
        }

        return $this->savedEmailFactory->createSavedEmailWithRequired(
            $email,
            $type
        );
    }
}
