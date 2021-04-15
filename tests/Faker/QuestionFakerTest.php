<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Question;
use App\Factory\QuestionFactory;
use App\Faker\QuestionFaker;
use App\Manager\QuestionManager;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
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
        $this->questionFactory = null;
        $this->questionFaker = null;
        $this->questionManager = null
        ;

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
        $this->assertSame($isEnabled, $question->getIsEnabled());
        $this->assertSame($position, $question->getPosition());
        $this->assertSame($title, $question->getTitle());
        $this->assertSame($type, $question->getType());
    }
}
