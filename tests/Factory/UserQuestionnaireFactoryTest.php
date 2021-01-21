<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\UserQuestionnaire;
use App\Factory\UserQuestionnaireFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

final class UserQuestionnaireFactoryTest extends AbstractTestCase
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

    public function testConstruct(): void
    {
        $userQuestionnaireFactory = new UserQuestionnaireFactory();

        $this->assertInstanceOf(UserQuestionnaireFactory::class, $userQuestionnaireFactory);
    }

    public function testCreateUserQuestionnaire(): void
    {
        $userQuestionnaireFactory = new UserQuestionnaireFactory();
        $userQuestionnaire = $userQuestionnaireFactory->createUserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire);
    }

    public function testCreateUserQuestionnaireWithRequired(): void
    {
        $isRewarded = $this->faker->boolean;
        $userQuestionnaireFactory = new UserQuestionnaireFactory();
        $userQuestionnaire = $userQuestionnaireFactory->createUserQuestionnaireWithRequired(
            $isRewarded
        );
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire);
        $this->assertEquals($isRewarded, $userQuestionnaire->getIsRewarded());
    }
}
