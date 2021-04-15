<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\UserQuestionnaire;
use App\Factory\UserQuestionnaireFactory;
use App\Tests\AbstractTestCase;
use Faker\{Factory, Generator};

/**
 * @internal
 */
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
        $this->faker = null;

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
        $isRewarded = $this->faker->boolean();
        $userQuestionnaireFactory = new UserQuestionnaireFactory();
        $userQuestionnaire = $userQuestionnaireFactory->createUserQuestionnaireWithRequired(
            $isRewarded
        );
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire);
        $this->assertSame($isRewarded, $userQuestionnaire->getIsRewarded());
    }
}
