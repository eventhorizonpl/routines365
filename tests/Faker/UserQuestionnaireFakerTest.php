<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\UserQuestionnaire;
use App\Factory\UserQuestionnaireFactory;
use App\Faker\QuestionnaireFaker;
use App\Faker\UserFaker;
use App\Faker\UserQuestionnaireFaker;
use App\Manager\UserQuestionnaireManager;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UserQuestionnaireFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserQuestionnaireFactory $userQuestionnaireFactory;
    /**
     * @inject
     */
    private ?UserQuestionnaireFaker $userQuestionnaireFaker;
    /**
     * @inject
     */
    private ?UserQuestionnaireManager $userQuestionnaireManager;

    protected function tearDown(): void
    {
        $this->questionnaireFaker = null;
        $this->userFaker = null;
        $this->userQuestionnaireFactory = null;
        $this->userQuestionnaireFaker = null;
        $this->userQuestionnaireManager = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userQuestionnaireFaker = new UserQuestionnaireFaker(
            $this->userQuestionnaireFactory,
            $this->userQuestionnaireManager
        );

        $this->assertInstanceOf(UserQuestionnaireFaker::class, $userQuestionnaireFaker);
    }

    public function testCreateUserQuestionnaire(): void
    {
        $this->purge();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire);
        $isRewarded = true;
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnaire(
            $isRewarded
        );
        $this->assertSame($isRewarded, $userQuestionnaire->getIsRewarded());
    }

    public function testCreateUserQuestionnairePersisted(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnairePersisted(
            $user,
            $questionnaire
        );
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire);
        $isRewarded = true;
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnairePersisted(
            $user,
            $questionnaire,
            $isRewarded
        );
        $this->assertSame($isRewarded, $userQuestionnaire->getIsRewarded());
    }
}
