<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Entity\User;
use App\Factory\AccountFactory;
use App\Factory\ProfileFactory;
use App\Factory\UserFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

class UserFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        unset($this->faker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $accountFactory = new AccountFactory();
        $profileFactory = new ProfileFactory();
        $userFactory = new UserFactory($accountFactory, $profileFactory);

        $this->assertInstanceOf(UserFactory::class, $userFactory);
    }

    public function testCreateUser()
    {
        $accountFactory = new AccountFactory();
        $profileFactory = new ProfileFactory();
        $userFactory = new UserFactory($accountFactory, $profileFactory);
        $user = $userFactory->createUser();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testCreateUserLead()
    {
        $accountFactory = new AccountFactory();
        $profileFactory = new ProfileFactory();
        $userFactory = new UserFactory($accountFactory, $profileFactory);
        $user = $userFactory->createUserLead();
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->getIsEnabled());
        $this->assertTrue($user->getIsVerified());
        $this->assertEquals(User::TYPE_LEAD, $user->getType());
    }

    public function testCreateUserWithRequired()
    {
        $email = $this->faker->safeEmail;
        $isEnabled = $this->faker->boolean;
        $roles = [
            User::ROLE_USER,
        ];
        $type = $this->faker->randomElement(
            User::getTypeFormChoices()
        );
        $accountFactory = new AccountFactory();
        $profileFactory = new ProfileFactory();
        $userFactory = new UserFactory($accountFactory, $profileFactory);
        $user = $userFactory->createUserWithRequired(
            $email,
            $isEnabled,
            $roles,
            $type
        );
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($isEnabled, $user->getIsEnabled());
        $this->assertEquals($roles, $user->getRoles());
        $this->assertEquals($type, $user->getType());
    }
}
