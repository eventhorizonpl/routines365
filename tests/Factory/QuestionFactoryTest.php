<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Question;
use App\Enum\QuestionTypeEnum;
use App\Factory\QuestionFactory;
use App\Tests\AbstractTestCase;
use Faker\{Factory, Generator};

/**
 * @internal
 */
final class QuestionFactoryTest extends AbstractTestCase
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
        $questionFactory = new QuestionFactory();

        $this->assertInstanceOf(QuestionFactory::class, $questionFactory);
    }

    public function testCreateQuestion(): void
    {
        $questionFactory = new QuestionFactory();
        $question = $questionFactory->createQuestion();
        $this->assertInstanceOf(Question::class, $question);
    }

    public function testCreateQuestionWithRequired(): void
    {
        $isEnabled = $this->faker->boolean();
        $position = $this->faker->numberBetween(1, 10);
        $title = $this->faker->sentence();
        $type = QuestionTypeEnum::SINGLE_ANSWER;
        $questionFactory = new QuestionFactory();
        $question = $questionFactory->createQuestionWithRequired(
            $isEnabled,
            $position,
            $title,
            $type
        );
        $this->assertInstanceOf(Question::class, $question);
        $this->assertSame($isEnabled, $question->getIsEnabled());
        $this->assertSame($position, $question->getPosition());
        $this->assertSame($title, $question->getTitle());
        $this->assertSame($type, $question->getType());
    }
}
