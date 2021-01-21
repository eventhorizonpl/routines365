<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Answer;
use App\Factory\AnswerFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

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
        unset($this->faker);

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
        $content = $this->faker->sentence;
        $isEnabled = $this->faker->boolean;
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
        $this->assertEquals($content, $answer->getContent());
        $this->assertEquals($isEnabled, $answer->getIsEnabled());
        $this->assertEquals($position, $answer->getPosition());
        $this->assertEquals($type, $answer->getType());
    }
}
