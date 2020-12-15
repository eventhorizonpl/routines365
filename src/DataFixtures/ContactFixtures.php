<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Faker\ContactFaker;
use App\Manager\ContactManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ContactFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const CONTACT_LIMIT = 5;
    public const CONTACT_REFERENCE = 'contact_reference';

    private ContactFaker $contactFaker;
    private ContactManager $contactManager;

    public function __construct(
        ContactFaker $contactFaker,
        ContactManager $contactManager
    ) {
        $this->contactFaker = $contactFaker;
        $this->contactManager = $contactManager;
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $kernel = $this->container->get('kernel');
        $contacts = [];
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            for ($userId = 1; $userId <= UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($contactId = 1; $contactId <= self::CONTACT_LIMIT; ++$contactId) {
                    $contact = $this->contactFaker->createContact();
                    $contact->setUser($this->getReference(UserFixtures::REGULAR_USER_REFERENCE.'_'.(string) $userId));
                    $contacts[] = $contact;
                    $this->addReference(self::CONTACT_REFERENCE.'-'.(string) $userId.'-'.(string) $contactId, $contact);
                }
            }
        }

        $this->contactManager->bulkSave($contacts);
    }
}