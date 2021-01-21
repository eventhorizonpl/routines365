<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\User;
use App\Factory\SentReminderFactory;
use App\Factory\UserFactory;
use App\Faker\AccountOperationFaker;
use App\Faker\AchievementFaker;
use App\Faker\AnswerFaker;
use App\Faker\CompletedRoutineFaker;
use App\Faker\ContactFaker;
use App\Faker\GoalFaker;
use App\Faker\NoteFaker;
use App\Faker\ProjectFaker;
use App\Faker\PromotionFaker;
use App\Faker\QuestionFaker;
use App\Faker\QuestionnaireFaker;
use App\Faker\QuoteFaker;
use App\Faker\ReminderFaker;
use App\Faker\ReminderMessageFaker;
use App\Faker\RewardFaker;
use App\Faker\RoutineFaker;
use App\Faker\SavedEmailFaker;
use App\Faker\UserFaker;
use App\Faker\UserQuestionnaireFaker;
use App\Manager\ReminderMessageManager;
use App\Manager\SentReminderManager;
use App\Manager\UserManager;
use App\Service\UserService;
use App\Tests\AbstractDoctrineTestCase;

final class UserFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AccountOperationFaker $accountOperationFaker;
    /**
     * @inject
     */
    private ?AchievementFaker $achievementFaker;
    /**
     * @inject
     */
    private ?AnswerFaker $answerFaker;
    /**
     * @inject
     */
    private ?CompletedRoutineFaker $completedRoutineFaker;
    /**
     * @inject
     */
    private ?ContactFaker $contactFaker;
    /**
     * @inject
     */
    private ?GoalFaker $goalFaker;
    /**
     * @inject
     */
    private ?NoteFaker $noteFaker;
    /**
     * @inject
     */
    private ?ProjectFaker $projectFaker;
    /**
     * @inject
     */
    private ?PromotionFaker $promotionFaker;
    /**
     * @inject
     */
    private ?QuestionFaker $questionFaker;
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?QuoteFaker $quoteFaker;
    /**
     * @inject
     */
    private ?ReminderFaker $reminderFaker;
    /**
     * @inject
     */
    private ?ReminderMessageFaker $reminderMessageFaker;
    /**
     * @inject
     */
    private ?ReminderMessageManager $reminderMessageManager;
    /**
     * @inject
     */
    private ?RewardFaker $rewardFaker;
    /**
     * @inject
     */
    private ?RoutineFaker $routineFaker;
    /**
     * @inject
     */
    private ?SavedEmailFaker $savedEmailFaker;
    /**
     * @inject
     */
    private ?SentReminderFactory $sentReminderFactory;
    /**
     * @inject
     */
    private ?SentReminderManager $sentReminderManager;
    /**
     * @inject
     */
    private ?UserFactory $userFactory;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserManager $userManager;
    /**
     * @inject
     */
    private ?UserQuestionnaireFaker $userQuestionnaireFaker;
    /**
     * @inject
     */
    private ?UserService $userService;

    protected function tearDown(): void
    {
        unset(
            $this->accountOperationFaker,
            $this->achievementFaker,
            $this->answerFaker,
            $this->completedRoutineFaker,
            $this->contactFaker,
            $this->goalFaker,
            $this->noteFaker,
            $this->projectFaker,
            $this->promotionFaker,
            $this->questionFaker,
            $this->questionnaireFaker,
            $this->quoteFaker,
            $this->reminderFaker,
            $this->reminderMessageFaker,
            $this->reminderMessageManager,
            $this->rewardFaker,
            $this->routineFaker,
            $this->savedEmailFaker,
            $this->sentReminderFactory,
            $this->sentReminderManager,
            $this->userFactory,
            $this->userFaker,
            $this->userManager,
            $this->userQuestionnaireFaker,
            $this->userService
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userFaker = new UserFaker(
            $this->accountOperationFaker,
            $this->achievementFaker,
            $this->answerFaker,
            $this->completedRoutineFaker,
            $this->contactFaker,
            $this->goalFaker,
            $this->noteFaker,
            $this->projectFaker,
            $this->promotionFaker,
            $this->questionFaker,
            $this->questionnaireFaker,
            $this->quoteFaker,
            $this->reminderFaker,
            $this->reminderMessageFaker,
            $this->reminderMessageManager,
            $this->rewardFaker,
            $this->routineFaker,
            $this->savedEmailFaker,
            $this->sentReminderFactory,
            $this->sentReminderManager,
            $this->userFactory,
            $this->userManager,
            $this->userQuestionnaireFaker,
            $this->userService
        );

        $this->assertInstanceOf(UserFaker::class, $userFaker);
    }

    public function testCreateUser(): void
    {
        $this->purge();
        $user = $this->userFaker->createUser();
        $this->assertInstanceOf(User::class, $user);
        $email = 'test@example.org';
        $isEnabled = true;
        $password = 'test password';
        $roles = [User::ROLE_USER];
        $type = User::TYPE_STAFF;
        $user = $this->userFaker->createUser(
            $email,
            $isEnabled,
            $password,
            $roles,
            $type
        );
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($isEnabled, $user->getIsEnabled());
        $this->assertEquals($roles, $user->getRoles());
        $this->assertEquals($type, $user->getType());
    }

    public function testCreateUserPersisted(): void
    {
        $this->purge();
        $user = $this->userFaker->createUserPersisted();
        $this->assertInstanceOf(User::class, $user);
        $email = 'test@example.org';
        $isEnabled = true;
        $password = 'test password';
        $roles = [User::ROLE_USER];
        $type = User::TYPE_STAFF;
        $user = $this->userFaker->createUserPersisted(
            $email,
            $isEnabled,
            $password,
            $roles,
            $type
        );
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($isEnabled, $user->getIsEnabled());
        $this->assertEquals($roles, $user->getRoles());
        $this->assertEquals($type, $user->getType());
    }

    public function testCreateRichUserPersisted(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $this->assertInstanceOf(User::class, $user);
    }
}
