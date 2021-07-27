<?php

declare(strict_types=1);

namespace App\Tests\EventSubscriber;

use App\Event\UserLastActivityUpdate;
use App\EventSubscriber\UserSubscriber;
use App\Faker\UserFaker;
use App\Manager\UserManager;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;

/**
 * @internal
 */
final class UserSubscriberTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserManager $userManager;
    /**
     * @inject
     */
    private ?UserSubscriber $userSubscriber;

    protected function tearDown(): void
    {
        $this->userFaker = null;
        $this->userManager = null;
        $this->userSubscriber = null;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userSubscriber = new UserSubscriber($this->userManager);

        $this->assertInstanceOf(UserSubscriber::class, $userSubscriber);
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertIsArray($this->userSubscriber->getSubscribedEvents());
        $this->assertCount(1, $this->userSubscriber->getSubscribedEvents());
    }

    public function testOnLastActivityUpdate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $this->assertNull($user->getLastActivityAt());

        $userLastActivityUpdate = new UserLastActivityUpdate($user);

        $this->assertNull($this->userSubscriber->onLastActivityUpdate($userLastActivityUpdate));
        $this->assertInstanceOf(DateTimeImmutable::class, $user->getLastActivityAt());
    }
}
