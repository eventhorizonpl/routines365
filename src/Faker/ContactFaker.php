<?php

namespace App\Faker;

use App\Entity\Contact;
use App\Factory\ContactFactory;
use App\Manager\ContactManager;
use Faker\Factory;
use Faker\Generator;

class ContactFaker
{
    private ContactFactory $contactFactory;
    private ContactManager $contactManager;
    private Generator $faker;

    public function __construct(
        ContactFactory $contactFactory,
        ContactManager $contactManager
    ) {
        $this->faker = Factory::create();
        $this->contactFactory = $contactFactory;
        $this->contactManager = $contactManager;
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

    public function createContactPersisted(
        ?string $content = null,
        ?string $status = null,
        ?string $title = null,
        ?string $type = null
    ): Contact {
        $contact = $this->createContact(
            $content,
            $status,
            $title,
            $type
        );
        $this->contactManager->save($contact);

        return $contact;
    }
}
