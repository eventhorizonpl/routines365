<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Questionnaire;
use App\Factory\QuestionnaireFactory;
use App\Faker\AnswerFaker;
use App\Faker\QuestionFaker;
use App\Faker\QuestionnaireFaker;
use App\Manager\QuestionnaireManager;
use App\Tests\AbstractDoctrineTestCase;

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
        unset(
            $this->answerFaker,
            $this->questionFaker,
            $this->questionnaireFactory,
            $this->questionnaireFaker,
            $this->questionnaireManager
        );

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
        $this->assertEquals($isEnabled, $questionnaire->getIsEnabled());
        $this->assertEquals($title, $questionnaire->getTitle());
    }

    public function testCreateRichQuestionnairePersisted(): void
    {
        $this->purge();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire);
    }
}
