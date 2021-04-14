<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\User;
use App\Factory\AccountFactory;
use App\Factory\ProfileFactory;
use App\Factory\UserFactory;
use App\Factory\UserKytFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

/**
 * @internal
 * @coversNothing
 */
final class UserFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        $this->faker = null;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $accountFactory = new AccountFactory();
        $profileFactory = new ProfileFactory();
        $userKytFactory = new UserKytFactory();
        $userFactory = new UserFactory($accountFactory, $profileFactory, $userKytFactory);

        $this->assertInstanceOf(UserFactory::class, $userFactory);
    }

    public function testCreateUser(): void
    {
        $accountFactory = new AccountFactory();
        $profileFactory = new ProfileFactory();
        $userKytFactory = new UserKytFactory();
        $userFactory = new UserFactory($accountFactory, $profileFactory, $userKytFactory);
        $user = $userFactory->createUser();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testCreateUserLead(): void
    {
        $accountFactory = new AccountFactory();
        $profileFactory = new ProfileFactory();
        $userKytFactory = new UserKytFactory();
        $userFactory = new UserFactory($accountFactory, $profileFactory, $userKytFactory);
        $user = $userFactory->createUserLead();
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->getIsEnabled());
        $this->assertTrue($user->getIsVerified());
        $this->assertSame(User::TYPE_LEAD, $user->getType());
    }

    public function testCreateUserWithRequired(): void
    {
        $email = $this->faker->safeEmail();
        $isEnabled = $this->faker->boolean();
        $roles = [
            User::ROLE_USER,
        ];
        $type = $this->faker->randomElement(
            User::getTypeFormChoices()
        );
        $accountFactory = new AccountFactory();
        $profileFactory = new ProfileFactory();
        $userKytFactory = new UserKytFactory();
        $userFactory = new UserFactory($accountFactory, $profileFactory, $userKytFactory);
        $user = $userFactory->createUserWithRequired(
            $email,
            $isEnabled,
            $roles,
            $type
        );
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($isEnabled, $user->getIsEnabled());
        $this->assertSame($roles, $user->getRoles());
        $this->assertSame($type, $user->getType());
    }
}
