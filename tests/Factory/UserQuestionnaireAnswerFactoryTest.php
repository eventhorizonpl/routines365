<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\UserQuestionnaireAnswer;
use App\Factory\UserQuestionnaireAnswerFactory;
use App\Tests\AbstractTestCase;
use Faker\{Factory, Generator};

/**
 * @internal
 */
final class UserQuestionnaireAnswerFactoryTest extends AbstractTestCase
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
        $userQuestionnaireAnswerFactory = new UserQuestionnaireAnswerFactory();

        $this->assertInstanceOf(UserQuestionnaireAnswerFactory::class, $userQuestionnaireAnswerFactory);
    }

    public function testCreateUserQuestionnaireAnswer(): void
    {
        $userQuestionnaireAnswerFactory = new UserQuestionnaireAnswerFactory();
        $userQuestionnaireAnswer = $userQuestionnaireAnswerFactory->createUserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer);
    }
}
