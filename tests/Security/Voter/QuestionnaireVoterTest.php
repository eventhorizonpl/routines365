<?php

declare(strict_types=1);

namespace App\Tests\Security\Voter;

use App\Faker\{QuestionnaireFaker, UserFaker};
use App\Security\Voter\QuestionnaireVoter;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use ReflectionMethod;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * @internal
 */
final class QuestionnaireVoterTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?QuestionnaireVoter $questionnaireVoter;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->questionnaireFaker = null;
        $this->questionnaireVoter = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testSupports(): void
    {
        $questionnaire = $this->questionnaireFaker->createQuestionnaire();

        $method = new ReflectionMethod(QuestionnaireVoter::class, 'supports');
        $method->setAccessible(true);
        $questionnaireVoter = new QuestionnaireVoter();

        $this->assertTrue($method->invoke($questionnaireVoter, QuestionnaireVoter::COMPLETE, $questionnaire));
    }

    public function testVoteOnAttribute(): void
    {
        $questionnaire1 = $this->questionnaireFaker->createQuestionnaire(true);
        $user1 = $this->userFaker->createUser();
        $token1 = new AnonymousToken('test', $user1);

        $method = new ReflectionMethod(QuestionnaireVoter::class, 'voteOnAttribute');
        $method->setAccessible(true);
        $questionnaireVoter = new QuestionnaireVoter();

        $this->assertTrue($method->invoke($questionnaireVoter, QuestionnaireVoter::COMPLETE, $questionnaire1, $token1));
        $questionnaire1->setIsEnabled(false);
        $this->assertFalse($method->invoke($questionnaireVoter, QuestionnaireVoter::COMPLETE, $questionnaire1, $token1));
        $questionnaire1->setIsEnabled(true);
        $this->assertTrue($method->invoke($questionnaireVoter, QuestionnaireVoter::COMPLETE, $questionnaire1, $token1));
        $questionnaire1->setDeletedAt(new DateTimeImmutable());
        $this->assertFalse($method->invoke($questionnaireVoter, QuestionnaireVoter::COMPLETE, $questionnaire1, $token1));
    }
}
