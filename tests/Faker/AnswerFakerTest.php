<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Answer;
use App\Factory\AnswerFactory;
use App\Faker\AnswerFaker;
use App\Manager\AnswerManager;
use App\Tests\AbstractDoctrineTestCase;

final class AnswerFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AnswerFactory $answerFactory;
    /**
     * @inject
     */
    private ?AnswerFaker $answerFaker;
    /**
     * @inject
     */
    private ?AnswerManager $answerManager;

    protected function tearDown(): void
    {
        unset(
            $this->answerFactory,
            $this->answerFaker,
            $this->answerManager
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $answerFaker = new AnswerFaker($this->answerFactory, $this->answerManager);

        $this->assertInstanceOf(AnswerFaker::class, $answerFaker);
    }

    public function testCreateAnswer(): void
    {
        $this->purge();
        $answer = $this->answerFaker->createAnswer();
        $this->assertInstanceOf(Answer::class, $answer);
        $content = 'test content';
        $isEnabled = true;
        $position = 1;
        $type = Answer::TYPE_DEFINED;
        $answer = $this->answerFaker->createAnswer(
            $content,
            $isEnabled,
            $position,
            $type
        );
        $this->assertEquals($content, $answer->getContent());
        $this->assertEquals($isEnabled, $answer->getIsEnabled());
        $this->assertEquals($position, $answer->getPosition());
        $this->assertEquals($type, $answer->getType());
    }
}
