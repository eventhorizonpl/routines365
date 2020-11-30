<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\SavedEmail;
use App\Factory\SavedEmailFactory;
use App\Faker\SavedEmailFaker;
use App\Tests\AbstractDoctrineTestCase;

class SavedEmailFakerTest extends AbstractDoctrineTestCase
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

    public function testConstruct()
    {
        $savedEmailFaker = new SavedEmailFaker($this->savedEmailFactory);

        $this->assertInstanceOf(SavedEmailFaker::class, $savedEmailFaker);
    }

    public function testCreateSavedEmail()
    {
        $this->purge();
        $savedEmail = $this->savedEmailFaker->createSavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail);
        $email = 'test email';
        $type = 'test type';
        $savedEmail = $this->savedEmailFaker->createSavedEmail(
            $email,
            $type
        );
        $this->assertEquals($email, $savedEmail->getEmail());
        $this->assertEquals($type, $savedEmail->getType());
    }
}
