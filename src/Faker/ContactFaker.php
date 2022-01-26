<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Contact;
use App\Enum\{ContactStatusEnum, ContactTypeEnum};
use App\Factory\ContactFactory;
use Faker\{Factory, Generator};

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
        ?ContactStatusEnum $status = null,
        ?string $title = null,
        ?ContactTypeEnum $type = null
    ): Contact {
        if (null === $content) {
            $content = (string) $this->faker->text();
        }

        if (null === $status) {
            $status = ContactStatusEnum::SPAM;
        }

        if (null === $title) {
            $title = (string) $this->faker->word();
        }

        if (null === $type) {
            $type = ContactTypeEnum::FEATURE_IDEA;
        }

        return $this->contactFactory->createContactWithRequired(
            $content,
            $status,
            $title,
            $type
        );
    }
}
