<?php

declare(strict_types=1);

namespace App\Tests\Event;

use App\Entity\User;
use App\Event\UserLastActivityUpdate;
use App\Faker\UserFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class UserLastActivityUpdateTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->userFaker = null;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $userLastActivityUpdate = new UserLastActivityUpdate($user);

        $this->assertInstanceOf(UserLastActivityUpdate::class, $userLastActivityUpdate);
    }

    public function testGetUser(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $userLastActivityUpdate = new UserLastActivityUpdate($user);

        $this->assertInstanceOf(User::class, $userLastActivityUpdate->getUser());
    }
}
