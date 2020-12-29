<?php

declare(strict_types=1);

namespace App\Tests\Security\Voter;

use App\Faker\ProjectFaker;
use App\Faker\UserFaker;
use App\Security\Voter\ProjectVoter;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use ReflectionMethod;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

final class ProjectVoterTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ProjectFaker $projectFaker;
    /**
     * @inject
     */
    private ?ProjectVoter $projectVoter;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset($this->projectFaker);
        unset($this->projectVoter);
        unset($this->userFaker);

        parent::tearDown();
    }

    public function testSupports(): void
    {
        $project = $this->projectFaker->createProject();

        $method = new ReflectionMethod(ProjectVoter::class, 'supports');
        $method->setAccessible(true);
        $projectVoter = new ProjectVoter();

        $this->assertTrue($method->invoke($projectVoter, ProjectVoter::DELETE, $project));
        $this->assertTrue($method->invoke($projectVoter, ProjectVoter::EDIT, $project));
        $this->assertTrue($method->invoke($projectVoter, ProjectVoter::VIEW, $project));
    }

    public function testVoteOnAttribute(): void
    {
        $project1 = $this->projectFaker->createProject();
        $user1 = $this->userFaker->createUser();
        $project1->setUser($user1);
        $token1 = new AnonymousToken('test', $user1);
        $user2 = $this->userFaker->createUser();
        $token2 = new AnonymousToken('test', $user2);

        $method = new ReflectionMethod(ProjectVoter::class, 'voteOnAttribute');
        $method->setAccessible(true);
        $projectVoter = new ProjectVoter();

        $this->assertTrue($method->invoke($projectVoter, ProjectVoter::DELETE, $project1, $token1));
        $this->assertTrue($method->invoke($projectVoter, ProjectVoter::EDIT, $project1, $token1));
        $this->assertTrue($method->invoke($projectVoter, ProjectVoter::VIEW, $project1, $token1));
        $project1->setDeletedAt(new DateTimeImmutable());
        $this->assertFalse($method->invoke($projectVoter, ProjectVoter::VIEW, $project1, $token1));
        $this->assertFalse($method->invoke($projectVoter, 'WRONG', $project1, $token1));
        $this->assertFalse($method->invoke($projectVoter, ProjectVoter::DELETE, $project1, $token2));
        $this->assertFalse($method->invoke($projectVoter, ProjectVoter::EDIT, $project1, $token2));
        $this->assertFalse($method->invoke($projectVoter, ProjectVoter::VIEW, $project1, $token2));
    }
}
