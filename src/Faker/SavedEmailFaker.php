<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\SavedEmail;
use App\Factory\SavedEmailFactory;
use Faker\Factory;
use Faker\Generator;

class SavedEmailFaker
{
    private Generator $faker;
    private SavedEmailFactory $savedEmailFactory;

    public function __construct(
        SavedEmailFactory $savedEmailFactory
    ) {
        $this->faker = Factory::create();
        $this->savedEmailFactory = $savedEmailFactory;
    }

    public function createSavedEmail(
        ?string $email = null,
        ?string $type = null
    ): SavedEmail {
        if (null === $email) {
            $email = (string) $this->faker->safeEmail;
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                SavedEmail::getTypeFormChoices()
            );
        }

        $savedEmail = $this->savedEmailFactory->createSavedEmailWithRequired(
            $email,
            $type
        );

        return $savedEmail;
    }
}
