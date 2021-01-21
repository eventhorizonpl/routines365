<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\QuestionnaireFaker;
use App\Faker\UserFaker;
use App\Faker\UserQuestionnaireFaker;
use App\Manager\UserQuestionnaireManager;
use App\Repository\UserQuestionnaireRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class UserQuestionnaireRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
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
    private ?UserQuestionnaireFaker $userQuestionnaireFaker;
    /**
     * @inject
     */
    private ?UserQuestionnaireManager $userQuestionnaireManager;
    /**
     * @inject
     */
    private ?UserQuestionnaireRepository $userQuestionnaireRepository;

    protected function tearDown(): void
    {
        unset(
            $this->managerRegistry,
            $this->questionnaireFaker,
            $this->userFaker,
            $this->userQuestionnaireManager,
            $this->userQuestionnaireFaker,
            $this->userQuestionnaireRepository
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userQuestionnaireRepository = new UserQuestionnaireRepository($this->managerRegistry);

        $this->assertInstanceOf(UserQuestionnaireRepository::class, $userQuestionnaireRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnaire();
        $userQuestionnaire->setUser($user);
        $userQuestionnaire->setQuestionnaire($questionnaire);
        $userQuestionnaireManager = $this->userQuestionnaireManager->save($userQuestionnaire, (string) $user, true);

        $userQuestionnaires = $this->userQuestionnaireRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $userQuestionnaires);
        $this->assertIsArray($userQuestionnaires);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $userQuestionnaires = $this->userQuestionnaireRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $userQuestionnaires);
        $this->assertIsArray($userQuestionnaires);

        $parameters = [
            'query' => 'wrong email',
        ];
        $userQuestionnaires = $this->userQuestionnaireRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $userQuestionnaires);
        $this->assertIsArray($userQuestionnaires);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $userQuestionnaires = $this->userQuestionnaireRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $userQuestionnaires);
        $this->assertIsArray($userQuestionnaires);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $userQuestionnaires = $this->userQuestionnaireRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $userQuestionnaires);
        $this->assertIsArray($userQuestionnaires);
    }
}
