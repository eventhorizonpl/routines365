<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Contact;
use App\Factory\ContactFactory;
use Faker\Factory;
use Faker\Generator;

class ContactFaker
{
    private Generator $faker;

    public function __construct(
        private ContactFactory $contactFactory
    ) {
        $this->faker = Factory::create();
    }

    public function createContact(
        ?string $content = null,
        ?string $status = null,
        ?string $title = null,
        ?string $type = null
    ): Contact {
        if (null === $content) {
            $content = (string) $this->faker->text;
        }

        if (null === $status) {
            $status = (string) $this->faker->randomElement(
                Contact::getStatusValidationChoices()
            );
        }

        if (null === $title) {
            $title = (string) $this->faker->word;
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                Contact::getTypeValidationChoices()
            );
        }

        $contact = $this->contactFactory->createContactWithRequired(
            $content,
            $status,
            $title,
            $type
        );

        return $contact;
    }
}
