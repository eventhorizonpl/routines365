<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\User;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\{AccountManager, AccountOperationManager, CompletedRoutineManager, ContactManager, GoalManager, NoteManager, ProfileManager, ProjectManager, ReminderManager, RewardManager, RoutineManager, SavedEmailManager, TestimonialManager, UserKytManager, UserManager};
use App\Repository\UserRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 */
final class UserManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AccountManager $accountManager;
    /**
     * @inject
     */
    private ?AccountOperationManager $accountOperationManager;
    /**
     * @inject
     */
    private ?CompletedRoutineManager $completedRoutineManager;
    /**
     * @inject
     */
    private ?ContactManager $contactManager;
    /**
     * @inject
     */
    private ?GoalManager $goalManager;
    /**
     * @inject
     */
    private ?NoteManager $noteManager;
    /**
     * @inject
     */
    private ?ProfileManager $profileManager;
    /**
     * @inject
     */
    private ?ProjectManager $projectManager;
    /**
     * @inject
     */
    private ?ReminderManager $reminderManager;
    /**
     * @inject
     */
    private ?RewardManager $rewardManager;
    /**
     * @inject
     */
    private ?RoutineManager $routineManager;
    /**
     * @inject
     */
    private ?SavedEmailManager $savedEmailManager;
    /**
     * @inject
     */
    private ?TestimonialManager $testimonialManager;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserKytManager $userKytManager;
    /**
     * @inject
     */
    private ?UserManager $userManager;
    /**
     * @inject
     */
    private ?UserRepository $userRepository;
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        $this->accountManager = null;
        $this->accountOperationManager = null;
        $this->completedRoutineManager = null;
        $this->contactManager = null;
        $this->goalManager = null;
        $this->noteManager = null;
        $this->profileManager = null;
        $this->projectManager = null;
        $this->reminderManager = null;
        $this->rewardManager = null;
        $this->routineManager = null;
        $this->savedEmailManager = null;
        $this->testimonialManager = null;
        $this->userFaker = null;
        $this->userKytManager = null;
        $this->userManager = null;
        $this->userRepository = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userManager = new UserManager(
            $this->accountManager,
            $this->accountOperationManager,
            $this->completedRoutineManager,
            $this->contactManager,
            $this->entityManager,
            $this->goalManager,
            $this->noteManager,
            $this->profileManager,
            $this->projectManager,
            $this->reminderManager,
            $this->rewardManager,
            $this->routineManager,
            $this->savedEmailManager,
            $this->testimonialManager,
            $this->userKytManager,
            $this->validator
        );

        $this->assertInstanceOf(UserManager::class, $userManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $email = 'test@example.org';
        $user->setEmail($email);
        $userId = $user->getId();
        $users = [];
        $users[] = $user;

        $userManager = $this->userManager->bulkSave($users, (string) $user, 1);
        $this->assertInstanceOf(UserManager::class, $userManager);

        $user2 = $this->userRepository->findOneById($userId);
        $this->assertInstanceOf(User::class, $user2);
        $this->assertSame($email, $user2->getEmail());
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $userId = $user->getId();

        $userManager = $this->userManager->delete($user);
        $this->assertInstanceOf(UserManager::class, $userManager);

        $user2 = $this->userRepository->findOneById($userId);
        $this->assertNull($user2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $userManager = $this->userManager->save($user, (string) $user, true);
        $this->assertInstanceOf(UserManager::class, $userManager);

        $userManager = $this->userManager->save($user);
        $this->assertInstanceOf(UserManager::class, $userManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $user->setEmail('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $userManager = $this->userManager->save($user, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $userId = $user->getId();

        $userManager = $this->userManager->softDelete($user, (string) $user);
        $this->assertInstanceOf(UserManager::class, $userManager);

        $user2 = $this->userRepository->findOneById($userId);
        $this->assertInstanceOf(User::class, $user2);
        $this->assertTrue(null !== $user2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $userId = $user->getId();

        $userManager = $this->userManager->softDelete($user, (string) $user);
        $this->assertInstanceOf(UserManager::class, $userManager);

        $user2 = $this->userRepository->findOneById($userId);
        $this->assertInstanceOf(User::class, $user2);
        $this->assertTrue(null !== $user2->getDeletedAt());

        $userManager = $this->userManager->undelete($user);
        $this->assertInstanceOf(UserManager::class, $userManager);

        $user3 = $this->userRepository->findOneById($userId);
        $this->assertInstanceOf(User::class, $user3);
        $this->assertTrue(null === $user3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $errors = $this->userManager->validate($user);
        $this->assertCount(0, $errors);

        $user->setEmail('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->userManager->validate($user);
        $this->assertCount(2, $errors);
    }
}
