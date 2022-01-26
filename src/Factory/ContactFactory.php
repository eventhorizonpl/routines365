<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Contact;
use App\Enum\{ContactStatusEnum, ContactTypeEnum};
use Symfony\Component\Uid\Uuid;

class ContactFactory
{
    public function createContact(): Contact
    {
        $contact = new Contact();
        $contact->setUuid((string) Uuid::v4());

        return $contact;
    }

    public function createContactWithRequired(
        string $content,
        ContactStatusEnum $status,
        string $title,
        ContactTypeEnum $type
    ): Contact {
        $contact = $this->createContact();

        $contact
            ->setContent($content)
            ->setStatus($status)
            ->setTitle($title)
            ->setType($type)
        ;

        return $contact;
    }
}
