<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\QuestionnaireFaker;
use App\Repository\QuestionnaireRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class QuestionnaireRepositoryTest extends AbstractDoctrineTestCase
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
    private ?QuestionnaireRepository $questionnaireRepository;

    protected function tearDown(): void
    {
        unset(
            $this->managerRegistry,
            $this->questionnaireFaker,
            $this->questionnaireRepository
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $questionnaireRepository = new QuestionnaireRepository($this->managerRegistry);

        $this->assertInstanceOf(QuestionnaireRepository::class, $questionnaireRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();

        $questionnaires = $this->questionnaireRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $questionnaires);
        $this->assertIsArray($questionnaires);

        $parameters = [
            'query' => $questionnaire->getDescription(),
        ];
        $questionnaires = $this->questionnaireRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $questionnaires);
        $this->assertIsArray($questionnaires);

        $parameters = [
            'query' => 'wrong email',
        ];
        $questionnaires = $this->questionnaireRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $questionnaires);
        $this->assertIsArray($questionnaires);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $questionnaires = $this->questionnaireRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $questionnaires);
        $this->assertIsArray($questionnaires);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $questionnaires = $this->questionnaireRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $questionnaires);
        $this->assertIsArray($questionnaires);
    }
}
