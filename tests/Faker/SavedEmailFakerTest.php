<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\SavedEmail;
use App\Factory\SavedEmailFactory;
use App\Faker\SavedEmailFaker;
use App\Tests\AbstractDoctrineTestCase;

final class SavedEmailFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?SavedEmailFactory $savedEmailFactory;
    /**
     * @inject
     */
    private ?SavedEmailFaker $savedEmailFaker;

    protected function tearDown(): void
    {
        unset($this->savedEmailFactory);
        unset($this->savedEmailFaker);

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $savedEmailFaker = new SavedEmailFaker($this->savedEmailFactory);

        $this->assertInstanceOf(SavedEmailFaker::class, $savedEmailFaker);
    }

    public function testCreateSavedEmail(): void
    {
        $this->purge();
        $savedEmail = $this->savedEmailFaker->createSavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail);
        $email = 'test email';
        $type = SavedEmail::TYPE_INVITATION;
        $savedEmail = $this->savedEmailFaker->createSavedEmail(
            $email,
            $type
        );
        $this->assertEquals($email, $savedEmail->getEmail());
        $this->assertEquals($type, $savedEmail->getType());
    }
}
