<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\UserQuestionnaireAnswerRepository;
use App\Tests\AbstractDoctrineTestCase;
use Doctrine\Persistence\ManagerRegistry;

final class UserQuestionnaireAnswerRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;

    protected function tearDown(): void
    {
        unset(
            $this->managerRegistry,
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userQuestionnaireAnswerRepository = new UserQuestionnaireAnswerRepository($this->managerRegistry);

        $this->assertInstanceOf(UserQuestionnaireAnswerRepository::class, $userQuestionnaireAnswerRepository);
    }
}
