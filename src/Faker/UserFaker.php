<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\{AccountOperation, ReminderMessage, Reward, User};
use App\Enum\{AccountOperationTypeEnum, ReminderMessageTypeEnum, RewardTypeEnum, UserRoleEnum, UserTypeEnum};
use App\Factory\{SentReminderFactory, UserFactory};
use App\Manager\{ReminderMessageManager, SentReminderManager, UserManager};
use App\Service\UserService;
use Faker\{Factory, Generator};

class UserFaker
{
    public const ADMIN_EMAIL = 'admin@example.org';
    public const ADMIN_PASSWORD = 'admin';
    public const CUSTOMER_EMAIL = 'customer@example.org';
    public const CUSTOMER_PASSWORD = 'customer';

    private Generator $faker;

    public function __construct(
        private AccountOperationFaker $accountOperationFaker,
        private AchievementFaker $achievementFaker,
        private AnswerFaker $answerFaker,
        private CompletedRoutineFaker $completedRoutineFaker,
        private ContactFaker $contactFaker,
        private GoalFaker $goalFaker,
        private NoteFaker $noteFaker,
        private ProjectFaker $projectFaker,
        private PromotionFaker $promotionFaker,
        private QuestionFaker $questionFaker,
        private QuestionnaireFaker $questionnaireFaker,
        private QuoteFaker $quoteFaker,
        private ReminderFaker $reminderFaker,
        private ReminderMessageFaker $reminderMessageFaker,
        private ReminderMessageManager $reminderMessageManager,
        private RewardFaker $rewardFaker,
        private RoutineFaker $routineFaker,
        private SavedEmailFaker $savedEmailFaker,
        private SentReminderFactory $sentReminderFactory,
        private SentReminderManager $sentReminderManager,
        private TestimonialFaker $testimonialFaker,
        private UserFactory $userFactory,
        private UserManager $userManager,
        private UserQuestionnaireFaker $userQuestionnaireFaker,
        private UserService $userService
    ) {
        $this->faker = Factory::create();
    }

    public function createUser(
        ?string $email = null,
        ?bool $isEnabled = null,
        ?string $password = null,
        ?array $roles = null,
        ?string $type = null
    ): User {
        if (null === $email) {
            $email = (string) $this->faker->safeEmail();
        }

        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean();
        }

        if (null === $password) {
            $password = (string) $this->faker->word();
        }

        if (null === $roles) {
            $roles = [UserRoleEnum::ROLE_USER];
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

        return $this->userService->encodePassword($user, $password);
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

    public function createAdminUserPersisted(
        ?string $email = null,
        ?string $password = null
    ): User {
        if (null === $email) {
            $email = self::ADMIN_EMAIL;
        }

        if (null === $password) {
            $password = self::ADMIN_PASSWORD;
        }

        return $this->createUserPersisted(
            $email,
            true,
            $password,
            [
                UserRoleEnum::ROLE_ADMIN,
                UserRoleEnum::ROLE_SUPER_ADMIN,
                UserRoleEnum::ROLE_USER,
            ],
            UserTypeEnum::STAFF
        );
    }

    public function createCustomerUserPersisted(
        ?string $email = null,
        ?string $password = null
    ): User {
        if (null === $email) {
            $email = self::CUSTOMER_EMAIL;
        }

        if (null === $password) {
            $password = self::CUSTOMER_PASSWORD;
        }

        return $this->createUserPersisted(
            $email,
            true,
            $password,
            [UserRoleEnum::ROLE_USER],
            UserTypeEnum::CUSTOMER
        );
    }

    public function createRichUserPersisted(
        ?string $email = null,
        ?string $password = null
    ): User {
        if (null === $email) {
            $email = self::CUSTOMER_EMAIL;
        }

        if (null === $password) {
            $password = self::CUSTOMER_PASSWORD;
        }

        $user = $this->createUser(
            $email,
            true,
            $password,
            [UserRoleEnum::ROLE_USER],
            UserTypeEnum::CUSTOMER
        );

        $user->getProfile()->setCountry('US');
        $accountOperation = $this->accountOperationFaker->createAccountOperation(
            null,
            null,
            null,
            AccountOperationTypeEnum::DEPOSIT
        );
        $user->getAccount()->addAccountOperation($accountOperation);

        $testimonial = $this->testimonialFaker->createTestimonial();
        $testimonial->setUser($user);
        $user->setTestimonial($testimonial);

        $routine = $this->routineFaker->createRoutine();
        $user->addRoutine($routine);

        $completedRoutine = $this->completedRoutineFaker->createCompletedRoutine();
        $completedRoutine->setRoutine($routine);
        $user->addCompletedRoutine($completedRoutine);

        $goal = $this->goalFaker->createGoal();
        $goal->setRoutine($routine);
        $routine->addGoal($goal);
        $user->addGoal($goal);

        $contact = $this->contactFaker->createContact();
        $user->addContact($contact);

        $note = $this->noteFaker->createNote();
        $note->setRoutine($routine);
        $user->addNote($note);

        $project = $this->projectFaker->createProject();
        $goal->setProject($project);
        $project->addGoal($goal);
        $user->addProject($project);

        $reminder = $this->reminderFaker->createReminder();
        $reminder->setRoutine($routine);
        $reminder->setSendToBrowser(true);
        $user->addReminder($reminder);

        $reward = $this->rewardFaker->createReward(null, null, null, null, null, RewardTypeEnum::COMPLETED_ROUTINE);
        $user->addReward($reward);
        $routine->addReward($reward);

        $savedEmail = $this->savedEmailFaker->createSavedEmail();
        $user->addSavedEmail($savedEmail);

        $this->userManager->save($user, null, true, true);

        $sentReminder = $this->sentReminderFactory->createSentReminder();
        $sentReminder
            ->setReminder($reminder)
            ->setRoutine($routine)
        ;
        $this->sentReminderManager->save($sentReminder);
        $user->getRoutines()->first()->addSentReminder($sentReminder);

        $reminderMessage = $this->reminderMessageFaker->createReminderMessage(
            null,
            ReminderMessageTypeEnum::BROWSER
        );
        $reminderMessage
            ->setAccountOperation($accountOperation)
            ->setReminder($reminder)
            ->setSentReminder($sentReminder)
        ;
        $this->reminderMessageManager->save($reminderMessage);
        $user->getReminders()->first()->addReminderMessage($reminderMessage);

        $reminderMessage = $this->reminderMessageFaker->createReminderMessage(
            null,
            ReminderMessageTypeEnum::EMAIL
        );
        $reminderMessage
            ->setAccountOperation($accountOperation)
            ->setReminder($reminder)
            ->setSentReminder($sentReminder)
        ;
        $this->reminderMessageManager->save($reminderMessage);
        $user->getReminders()->first()->addReminderMessage($reminderMessage);

        return $user;
    }
}
