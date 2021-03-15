<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\SavedEmail;
use App\Factory\SavedEmailFactory;
use App\Faker\SavedEmailFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 * @coversNothing
 */
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
        $this->savedEmailFactory = null;
        $this->savedEmailFaker = null
        ;

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
        $this->assertSame($email, $savedEmail->getEmail());
        $this->assertSame($type, $savedEmail->getType());
    }
}
