<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Questionnaire;
use App\Exception\ManagerException;
use App\Faker\{QuestionnaireFaker, UserFaker};
use App\Manager\{QuestionManager, QuestionnaireManager};
use App\Repository\QuestionnaireRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 * @coversNothing
 */
final class QuestionnaireManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuestionManager $questionManager;
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?QuestionnaireManager $questionnaireManager;
    /**
     * @inject
     */
    private ?QuestionnaireRepository $questionnaireRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        $this->questionManager = null;
        $this->questionnaireFaker = null;
        $this->questionnaireManager = null;
        $this->questionnaireRepository = null;
        $this->userFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $questionnaireManager = new QuestionnaireManager(
            $this->entityManager,
            $this->questionManager,
            $this->validator
        );

        $this->assertInstanceOf(QuestionnaireManager::class, $questionnaireManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createQuestionnaire();
        $questionnaireUuid = $questionnaire->getUuid();
        $questionnaires = [];
        $questionnaires[] = $questionnaire;
        $questionnaireManager = $this->questionnaireManager->bulkSave($questionnaires, (string) $user, 1);
        $this->assertInstanceOf(QuestionnaireManager::class, $questionnaireManager);

        $questionnaire2 = $this->questionnaireRepository->findOneByUuid($questionnaireUuid);
        $this->assertInstanceOf(Questionnaire::class, $questionnaire2);
    }

    public function testDelete(): void
    {
        $this->purge();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $questionnaireId = $questionnaire->getId();

        $questionnaireManager = $this->questionnaireManager->delete($questionnaire);
        $this->assertInstanceOf(QuestionnaireManager::class, $questionnaireManager);

        $questionnaire2 = $this->questionnaireRepository->findOneById($questionnaireId);
        $this->assertNull($questionnaire2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createQuestionnaire();

        $questionnaireManager = $this->questionnaireManager->save($questionnaire, (string) $user, true);
        $this->assertInstanceOf(QuestionnaireManager::class, $questionnaireManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createQuestionnaire();
        $questionnaire->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $questionnaireManager = $this->questionnaireManager->save($questionnaire, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $questionnaireId = $questionnaire->getId();

        $questionnaireManager = $this->questionnaireManager->softDelete($questionnaire, (string) $user);
        $this->assertInstanceOf(QuestionnaireManager::class, $questionnaireManager);

        $questionnaire2 = $this->questionnaireRepository->findOneById($questionnaireId);
        $this->assertInstanceOf(Questionnaire::class, $questionnaire2);
        $this->assertTrue(null !== $questionnaire2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $questionnaireId = $questionnaire->getId();

        $questionnaireManager = $this->questionnaireManager->softDelete($questionnaire, (string) $user);
        $this->assertInstanceOf(QuestionnaireManager::class, $questionnaireManager);

        $questionnaire2 = $this->questionnaireRepository->findOneById($questionnaireId);
        $this->assertInstanceOf(Questionnaire::class, $questionnaire2);
        $this->assertTrue(null !== $questionnaire2->getDeletedAt());

        $questionnaireManager = $this->questionnaireManager->undelete($questionnaire);
        $this->assertInstanceOf(QuestionnaireManager::class, $questionnaireManager);

        $questionnaire3 = $this->questionnaireRepository->findOneById($questionnaireId);
        $this->assertInstanceOf(Questionnaire::class, $questionnaire3);
        $this->assertTrue(null === $questionnaire3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();

        $errors = $this->questionnaireManager->validate($questionnaire);
        $this->assertCount(0, $errors);

        $questionnaire->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->questionnaireManager->validate($questionnaire);
        $this->assertCount(1, $errors);
    }
}
