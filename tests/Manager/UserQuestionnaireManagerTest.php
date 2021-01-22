<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\UserQuestionnaire;
use App\Faker\QuestionnaireFaker;
use App\Faker\UserFaker;
use App\Faker\UserQuestionnaireFaker;
use App\Manager\UserQuestionnaireManager;
use App\Repository\UserQuestionnaireRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserQuestionnaireManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?UserQuestionnaireFaker $userQuestionnaireFaker;
    /**
     * @inject
     */
    private ?UserQuestionnaireManager $userQuestionnaireManager;
    /**
     * @inject
     */
    private ?UserQuestionnaireRepository $userQuestionnaireRepository;
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
        unset(
            $this->userQuestionnaireFaker,
            $this->userQuestionnaireManager,
            $this->userQuestionnaireRepository,
            $this->userFaker,
            $this->validator
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userQuestionnaireManager = new UserQuestionnaireManager(
            $this->entityManager,
            $this->validator
        );

        $this->assertInstanceOf(UserQuestionnaireManager::class, $userQuestionnaireManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnaire();
        $userQuestionnaire->setUser($user);
        $userQuestionnaire->setQuestionnaire($questionnaire);
        $userQuestionnaireUuid = $userQuestionnaire->getUuid();
        $userQuestionnaires = [];
        $userQuestionnaires[] = $userQuestionnaire;
        $userQuestionnaireManager = $this->userQuestionnaireManager->bulkSave($userQuestionnaires, (string) $user, 1);
        $this->assertInstanceOf(UserQuestionnaireManager::class, $userQuestionnaireManager);

        $userQuestionnaire2 = $this->userQuestionnaireRepository->findOneByUuid($userQuestionnaireUuid);
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire2);
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnairePersisted($user, $questionnaire);
        $userQuestionnaireId = $userQuestionnaire->getId();

        $userQuestionnaireManager = $this->userQuestionnaireManager->delete($userQuestionnaire);
        $this->assertInstanceOf(UserQuestionnaireManager::class, $userQuestionnaireManager);

        $userQuestionnaire2 = $this->userQuestionnaireRepository->findOneById($userQuestionnaireId);
        $this->assertNull($userQuestionnaire2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnaire();
        $userQuestionnaire->setUser($user);
        $userQuestionnaire->setQuestionnaire($questionnaire);

        $userQuestionnaireManager = $this->userQuestionnaireManager->save($userQuestionnaire, (string) $user, true);
        $this->assertInstanceOf(UserQuestionnaireManager::class, $userQuestionnaireManager);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnairePersisted($user, $questionnaire);
        $userQuestionnaireId = $userQuestionnaire->getId();

        $userQuestionnaireManager = $this->userQuestionnaireManager->softDelete($userQuestionnaire, (string) $user);
        $this->assertInstanceOf(UserQuestionnaireManager::class, $userQuestionnaireManager);

        $userQuestionnaire2 = $this->userQuestionnaireRepository->findOneById($userQuestionnaireId);
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire2);
        $this->assertTrue(null !== $userQuestionnaire2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnairePersisted($user, $questionnaire);
        $userQuestionnaireId = $userQuestionnaire->getId();

        $userQuestionnaireManager = $this->userQuestionnaireManager->softDelete($userQuestionnaire, (string) $user);
        $this->assertInstanceOf(UserQuestionnaireManager::class, $userQuestionnaireManager);

        $userQuestionnaire2 = $this->userQuestionnaireRepository->findOneById($userQuestionnaireId);
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire2);
        $this->assertTrue(null !== $userQuestionnaire2->getDeletedAt());

        $userQuestionnaireManager = $this->userQuestionnaireManager->undelete($userQuestionnaire);
        $this->assertInstanceOf(UserQuestionnaireManager::class, $userQuestionnaireManager);

        $userQuestionnaire3 = $this->userQuestionnaireRepository->findOneById($userQuestionnaireId);
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire3);
        $this->assertTrue(null === $userQuestionnaire3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnairePersisted($user, $questionnaire);

        $errors = $this->userQuestionnaireManager->validate($userQuestionnaire);
        $this->assertCount(0, $errors);
    }
}