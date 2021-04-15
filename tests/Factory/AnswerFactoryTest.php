<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Answer;
use App\Factory\AnswerFactory;
use App\Tests\AbstractTestCase;
use Faker\{Factory, Generator};

/**
 * @internal
 */
final class AnswerFactoryTest extends AbstractTestCase
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
        $answerFactory = new AnswerFactory();

        $this->assertInstanceOf(AnswerFactory::class, $answerFactory);
    }

    public function testCreateAnswer(): void
    {
        $answerFactory = new AnswerFactory();
        $answer = $answerFactory->createAnswer();
        $this->assertInstanceOf(Answer::class, $answer);
    }

    public function testCreateAnswerWithRequired(): void
    {
        $content = $this->faker->sentence();
        $isEnabled = $this->faker->boolean();
        $position = $this->faker->numberBetween(1, 10);
        $type = $this->faker->randomElement(
            Answer::getTypeFormChoices()
        );
        $answerFactory = new AnswerFactory();
        $answer = $answerFactory->createAnswerWithRequired(
            $content,
            $isEnabled,
            $position,
            $type
        );
        $this->assertInstanceOf(Answer::class, $answer);
        $this->assertSame($content, $answer->getContent());
        $this->assertSame($isEnabled, $answer->getIsEnabled());
        $this->assertSame($position, $answer->getPosition());
        $this->assertSame($type, $answer->getType());
    }
}
