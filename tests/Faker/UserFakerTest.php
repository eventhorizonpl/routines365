<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\User;
use App\Enum\{UserRoleEnum, UserTypeEnum};
use App\Factory\{SentReminderFactory, UserFactory};
use App\Faker\{AccountOperationFaker, AchievementFaker, AnswerFaker, CompletedRoutineFaker, ContactFaker, GoalFaker, NoteFaker, ProjectFaker, PromotionFaker, QuestionFaker, QuestionnaireFaker, QuoteFaker, ReminderFaker, ReminderMessageFaker, RewardFaker, RoutineFaker, SavedEmailFaker, TestimonialFaker, UserFaker, UserQuestionnaireFaker};
use App\Manager\{ReminderMessageManager, SentReminderManager, UserManager};
use App\Service\UserService;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
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
    private ?TestimonialFaker $testimonialFaker;
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
        $this->accountOperationFaker = null;
        $this->achievementFaker = null;
        $this->answerFaker = null;
        $this->completedRoutineFaker = null;
        $this->contactFaker = null;
        $this->goalFaker = null;
        $this->noteFaker = null;
        $this->projectFaker = null;
        $this->promotionFaker = null;
        $this->questionFaker = null;
        $this->questionnaireFaker = null;
        $this->quoteFaker = null;
        $this->reminderFaker = null;
        $this->reminderMessageFaker = null;
        $this->reminderMessageManager = null;
        $this->rewardFaker = null;
        $this->routineFaker = null;
        $this->savedEmailFaker = null;
        $this->sentReminderFactory = null;
        $this->sentReminderManager = null;
        $this->testimonialFaker = null;
        $this->userFactory = null;
        $this->userFaker = null;
        $this->userManager = null;
        $this->userQuestionnaireFaker = null;
        $this->userService = null
        ;

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
            $this->testimonialFaker,
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
        $roles = [UserRoleEnum::ROLE_USER->value];
        $type = UserTypeEnum::STAFF;
        $user = $this->userFaker->createUser(
            $email,
            $isEnabled,
            $password,
            $roles,
            $type
        );
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($isEnabled, $user->getIsEnabled());
        $this->assertSame($roles, $user->getRoles());
        $this->assertSame($type, $user->getType());
    }

    public function testCreateUserPersisted(): void
    {
        $this->purge();
        $user = $this->userFaker->createUserPersisted();
        $this->assertInstanceOf(User::class, $user);
        $email = 'test@example.org';
        $isEnabled = true;
        $password = 'test password';
        $roles = [UserRoleEnum::ROLE_USER->value];
        $type = UserTypeEnum::STAFF;
        $user = $this->userFaker->createUserPersisted(
            $email,
            $isEnabled,
            $password,
            $roles,
            $type
        );
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($isEnabled, $user->getIsEnabled());
        $this->assertSame($roles, $user->getRoles());
        $this->assertSame($type, $user->getType());
    }

    public function testCreateRichUserPersisted(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $this->assertInstanceOf(User::class, $user);
    }
}
