<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\SavedEmail;
use App\Factory\SavedEmailFactory;
use App\Faker\UserFaker;
use App\Manager\SavedEmailManager;
use App\Service\SavedEmailService;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class SavedEmailServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?SavedEmailFactory $savedEmailFactory;
    /**
     * @inject
     */
    private ?SavedEmailManager $savedEmailManager;
    /**
     * @inject
     */
    private ?SavedEmailService $savedEmailService;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->savedEmailFactory = null;
        $this->savedEmailManager = null;
        $this->savedEmailService = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $savedEmailService = new SavedEmailService($this->savedEmailFactory, $this->savedEmailManager);

        $this->assertInstanceOf(SavedEmailService::class, $savedEmailService);
    }

    public function testCreate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $email = 'test@example.org';
        $type = SavedEmail::TYPE_INVITATION;
        $savedEmail = $this->savedEmailService->create(
            $email,
            $type,
            $user
        );
        $this->assertInstanceOf(SavedEmail::class, $savedEmail);
        $this->assertSame($email, $savedEmail->getEmail());
        $this->assertSame($type, $savedEmail->getType());
    }
}
