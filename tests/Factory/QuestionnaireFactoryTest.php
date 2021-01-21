<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Questionnaire;
use App\Factory\QuestionnaireFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

final class QuestionnaireFactoryTest extends AbstractTestCase
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
        $questionnaireFactory = new QuestionnaireFactory();

        $this->assertInstanceOf(QuestionnaireFactory::class, $questionnaireFactory);
    }

    public function testCreateQuestionnaire(): void
    {
        $questionnaireFactory = new QuestionnaireFactory();
        $questionnaire = $questionnaireFactory->createQuestionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire);
    }

    public function testCreateQuestionnaireWithRequired(): void
    {
        $isEnabled = $this->faker->boolean;
        $title = $this->faker->sentence;
        $questionnaireFactory = new QuestionnaireFactory();
        $questionnaire = $questionnaireFactory->createQuestionnaireWithRequired(
            $isEnabled,
            $title
        );
        $this->assertInstanceOf(Questionnaire::class, $questionnaire);
        $this->assertEquals($isEnabled, $questionnaire->getIsEnabled());
        $this->assertEquals($title, $questionnaire->getTitle());
    }
}
