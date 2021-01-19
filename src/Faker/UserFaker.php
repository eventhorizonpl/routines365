<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\AccountOperation;
use App\Entity\User;
use App\Factory\SentReminderFactory;
use App\Factory\UserFactory;
use App\Manager\ReminderMessageManager;
use App\Manager\SentReminderManager;
use App\Manager\UserManager;
use App\Service\UserService;
use Faker\Factory;
use Faker\Generator;

class UserFaker
{
    private AccountOperationFaker $accountOperationFaker;
    private AchievementFaker $achievementFaker;
    private CompletedRoutineFaker $completedRoutineFaker;
    private ContactFaker $contactFaker;
    private Generator $faker;
    private GoalFaker $goalFaker;
    private NoteFaker $noteFaker;
    private ProjectFaker $projectFaker;
    private PromotionFaker $promotionFaker;
    private QuoteFaker $quoteFaker;
    private ReminderFaker $reminderFaker;
    private ReminderMessageFaker $reminderMessageFaker;
    private ReminderMessageManager $reminderMessageManager;
    private RewardFaker $rewardFaker;
    private RoutineFaker $routineFaker;
    private SavedEmailFaker $savedEmailFaker;
    private SentReminderFactory $sentReminderFactory;
    private SentReminderManager $sentReminderManager;
    private UserFactory $userFactory;
    private UserManager $userManager;
    private UserService $userService;

    public function __construct(
        AccountOperationFaker $accountOperationFaker,
        AchievementFaker $achievementFaker,
        CompletedRoutineFaker $completedRoutineFaker,
        ContactFaker $contactFaker,
        GoalFaker $goalFaker,
        NoteFaker $noteFaker,
        ProjectFaker $projectFaker,
        PromotionFaker $promotionFaker,
        QuoteFaker $quoteFaker,
        ReminderFaker $reminderFaker,
        ReminderMessageFaker $reminderMessageFaker,
        ReminderMessageManager $reminderMessageManager,
        RewardFaker $rewardFaker,
        RoutineFaker $routineFaker,
        SavedEmailFaker $savedEmailFaker,
        SentReminderFactory $sentReminderFactory,
        SentReminderManager $sentReminderManager,
        UserFactory $userFactory,
        UserManager $userManager,
        UserService $userService
    ) {
        $this->accountOperationFaker = $accountOperationFaker;
        $this->achievementFaker = $achievementFaker;
        $this->completedRoutineFaker = $completedRoutineFaker;
        $this->contactFaker = $contactFaker;
        $this->faker = Factory::create();
        $this->goalFaker = $goalFaker;
        $this->noteFaker = $noteFaker;
        $this->projectFaker = $projectFaker;
        $this->promotionFaker = $promotionFaker;
        $this->quoteFaker = $quoteFaker;
        $this->reminderFaker = $reminderFaker;
        $this->reminderMessageFaker = $reminderMessageFaker;
        $this->reminderMessageManager = $reminderMessageManager;
        $this->rewardFaker = $rewardFaker;
        $this->routineFaker = $routineFaker;
        $this->savedEmailFaker = $savedEmailFaker;
        $this->sentReminderFactory = $sentReminderFactory;
        $this->sentReminderManager = $sentReminderManager;
        $this->userFactory = $userFactory;
        $this->userManager = $userManager;
        $this->userService = $userService;
    }

    public function createUser(
        ?string $email = null,
        ?bool $isEnabled = null,
        ?string $password = null,
        ?array $roles = null,
        ?string $type = null
    ): User {
        if (null === $email) {
            $email = (string) $this->faker->safeEmail;
        }

        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean;
        }

        if (null === $password) {
            $password = (string) $this->faker->word;
        }

        if (null === $roles) {
            $roles = [User::ROLE_USER];
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                User::getTypeFormChoices()
            );
        }

        $user = $this->userFactory->createUserWithRequired(
            $email,
            $isEnabled,
            $roles,
            $type
        );

        $user = $this->userService->encodePassword($user, $password);

        return $user;
    }

    public function createUserPersisted(
        ?string $email = null,
        ?bool $isEnabled = null,
        ?string $password = null,
        ?array $roles = null,
        ?string $type = null
    ): User {
        $user = $this->createUser(
            $email,
            $isEnabled,
            $password,
            $roles,
            $type
        );
        $this->userManager->save($user);

        return $user;
    }

    public function createRichUserPersisted()
    {
        $user = $this->createUser();
        $user->getProfile()->setCountry('US');
        $accountOperation = $this->accountOperationFaker->createAccountOperation(
            null,
            null,
            null,
            null,
            AccountOperation::TYPE_DEPOSIT
        );
        $user->getAccount()->addAccountOperation($accountOperation);

        $routine = $this->routineFaker->createRoutine();
        $user->addRoutine($routine);

        $completedRoutine = $this->completedRoutineFaker->createCompletedRoutine();
        $completedRoutine->setRoutine($routine);
        $user->addCompletedRoutine($completedRoutine);

        $goal = $this->goalFaker->createGoal();
        $goal->setRoutine($routine);
        $user->addGoal($goal);

        $contact = $this->contactFaker->createContact();
        $user->addContact($contact);

        $note = $this->noteFaker->createNote();
        $note->setRoutine($routine);
        $user->addNote($note);

        $project = $this->projectFaker->createProject();
        $user->addProject($project);

        $reminder = $this->reminderFaker->createReminder();
        $reminder->setRoutine($routine);
        $user->addReminder($reminder);

        $reward = $this->rewardFaker->createReward();
        $user->addReward($reward);

        $savedEmail = $this->savedEmailFaker->createSavedEmail();
        $user->addSavedEmail($savedEmail);

        $this->userManager->save($user, null, true, true);

        $sentReminder = $this->sentReminderFactory->createSentReminder();
        $sentReminder
            ->setReminder($reminder)
            ->setRoutine($routine);
        $this->sentReminderManager->save($sentReminder);
        $user->getRoutines()->first()->addSentReminder($sentReminder);

        $reminderMessage = $this->reminderMessageFaker->createReminderMessage();
        $reminderMessage
            ->setAccountOperation($accountOperation)
            ->setReminder($reminder)
            ->setSentReminder($sentReminder);
        $this->reminderMessageManager->save($reminderMessage);
        $user->getReminders()->first()->addReminderMessage($reminderMessage);

        return $user;
    }
}
