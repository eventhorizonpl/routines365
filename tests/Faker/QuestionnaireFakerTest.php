<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Questionnaire;
use App\Factory\QuestionnaireFactory;
use App\Faker\{AnswerFaker, QuestionFaker, QuestionnaireFaker};
use App\Manager\QuestionnaireManager;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 * @coversNothing
 */
final class QuestionnaireFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AnswerFaker $answerFaker;
    /**
     * @inject
     */
    private ?QuestionFaker $questionFaker;
    /**
     * @inject
     */
    private ?QuestionnaireFactory $questionnaireFactory;
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?QuestionnaireManager $questionnaireManager;

    protected function tearDown(): void
    {
        $this->answerFaker = null;
        $this->questionFaker = null;
        $this->questionnaireFactory = null;
        $this->questionnaireFaker = null;
        $this->questionnaireManager = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $questionnaireFaker = new QuestionnaireFaker(
            $this->answerFaker,
            $this->questionFaker,
            $this->questionnaireFactory,
            $this->questionnaireManager
        );

        $this->assertInstanceOf(QuestionnaireFaker::class, $questionnaireFaker);
    }

    public function testCreateQuestionnaire(): void
    {
        $this->purge();
        $questionnaire = $this->questionnaireFaker->createQuestionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire);
        $isEnabled = true;
        $title = 'test title';
        $questionnaire = $this->questionnaireFaker->createQuestionnaire(
            $isEnabled,
            $title
        );
        $this->assertSame($isEnabled, $questionnaire->getIsEnabled());
        $this->assertSame($title, $questionnaire->getTitle());
    }

    public function testCreateRichQuestionnairePersisted(): void
    {
        $this->purge();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire);
    }
}
