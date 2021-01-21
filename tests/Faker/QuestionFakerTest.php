<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Question;
use App\Factory\QuestionFactory;
use App\Faker\QuestionFaker;
use App\Manager\QuestionManager;
use App\Tests\AbstractDoctrineTestCase;

final class QuestionFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuestionFactory $questionFactory;
    /**
     * @inject
     */
    private ?QuestionFaker $questionFaker;
    /**
     * @inject
     */
    private ?QuestionManager $questionManager;

    protected function tearDown(): void
    {
        unset(
            $this->questionFactory,
            $this->questionFaker,
            $this->questionManager
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $questionFaker = new QuestionFaker($this->questionFactory, $this->questionManager);

        $this->assertInstanceOf(QuestionFaker::class, $questionFaker);
    }

    public function testCreateQuestion(): void
    {
        $this->purge();
        $question = $this->questionFaker->createQuestion();
        $this->assertInstanceOf(Question::class, $question);
        $isEnabled = true;
        $position = 1;
        $title = 'test content';
        $type = Question::TYPE_SINGLE_ANSWER;
        $question = $this->questionFaker->createQuestion(
            $isEnabled,
            $position,
            $title,
            $type
        );
        $this->assertEquals($isEnabled, $question->getIsEnabled());
        $this->assertEquals($position, $question->getPosition());
        $this->assertEquals($title, $question->getTitle());
        $this->assertEquals($type, $question->getType());
    }
}
