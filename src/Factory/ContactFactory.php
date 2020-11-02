<?php

namespace App\Factory;

use App\Entity\Contact;
use Symfony\Component\Uid\Uuid;

class ContactFactory
{
    public function createContact(): Contact
    {
        $contact = new Contact();
        $contact->setUuid(Uuid::v4());

        return $contact;
    }

    public function createContactWithRequired(
        string $content,
        string $status,
        string $title,
        string $type
    ): Contact {
        $contact = $this->createContact();

        $contact
            ->setContent($content)
            ->setStatus($status)
            ->setTitle($title)
            ->setType($type);

        return $contact;
    }
}
