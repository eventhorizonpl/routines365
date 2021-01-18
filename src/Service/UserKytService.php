<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\UserKyt;
use App\Factory\UserKytFactory;
use App\Manager\UserKytManager;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Knp\Component\Pager\PaginatorInterface;

class UserKytService
{
    private EmailService $emailService;
    private PaginatorInterface $paginator;
    private PromotionService $promotionService;
    private UserKytFactory $userKytFactory;
    private UserKytManager $userKytManager;
    private UserRepository $userRepository;

    public function __construct(
        EmailService $emailService,
        PaginatorInterface $paginator,
        PromotionService $promotionService,
        UserKytFactory $userKytFactory,
        UserKytManager $userKytManager,
        UserRepository $userRepository
    ) {
        $this->emailService = $emailService;
        $this->paginator = $paginator;
        $this->promotionService = $promotionService;
        $this->userKytFactory = $userKytFactory;
        $this->userKytManager = $userKytManager;
        $this->userRepository = $userRepository;
    }

    public function create(User $user): UserKyt
    {
        $userKyt = $this->userKytFactory->createUserKyt();
        $userKyt->setUser($user);
        $this->userKytManager->save($userKyt, (string) $user);

        return $userKyt;
    }

    public function createMissingUserKyt(): UserKytService
    {
        $page = 1;
        $limit = 5;

        $usersQuery = $this->userRepository->findForCreateMissingUserKyt();

        do {
            $users = $this->paginator->paginate($usersQuery, $page, $limit);

            foreach ($users as $user) {
                if (null === $user->getUserKyt()) {
                    $userKyt = $this->create($user);
                }
            }
            ++$page;
        } while ($users->getCurrentPageNumber() <= $users->getPageCount());

        return $this;
    }

    public function nurture(): UserKytService
    {
        $page = 1;
        $limit = 5;

        $usersQuery = $this->userRepository->findForPostUserKytMessages();

        do {
            $users = $this->paginator->paginate($usersQuery, $page, $limit);

            foreach ($users as $user) {
                $this->nurtureUserKyt($user);
            }
            ++$page;
        } while ($users->getCurrentPageNumber() <= $users->getPageCount());

        return $this;
    }

    public function nurtureUserKyt(User $user): User
    {
        $userKyt = $user->getUserKyt();
        $date = new DateTimeImmutable();

        if ((false === $userKyt->getBasicConfigurationLearned()) &&
            (false === $userKyt->getBasicConfigurationSent()) &&
            (null === $user->getProfile()->getTimeZone())
        ) {
            $this->emailService->sendUserKytBasicConfiguration(
                $user->getEmail(),
                'R365: Know your tools - basic configuration',
            );
            $userKyt->setBasicConfigurationSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getRoutinesLearned()) &&
            (false === $userKyt->getRoutinesSent()) &&
            (0 === count($user->getRoutinesAll()))
        ) {
            $this->emailService->sendUserKytRoutines(
                $user->getEmail(),
                'R365: Know your tools - routines',
            );
            $userKyt->setRoutinesSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getRemindersLearned()) &&
            (false === $userKyt->getRemindersSent()) &&
            (0 === count($user->getRemindersAll()))
        ) {
            $this->emailService->sendUserKytReminders(
                $user->getEmail(),
                'R365: Know your tools - reminders',
            );
            $userKyt->setRemindersSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getCompletingRoutinesLearned()) &&
            (false === $userKyt->getCompletingRoutinesSent()) &&
            (0 === count($user->getCompletedRoutinesAll()))
        ) {
            $this->emailService->sendUserKytCompletingRoutines(
                $user->getEmail(),
                'R365: Know your tools - completing routines',
            );
            $userKyt->setCompletingRoutinesSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getNotesLearned()) &&
            (false === $userKyt->getNotesSent()) &&
            (0 === count($user->getNotesAll()))
        ) {
            $this->emailService->sendUserKytNotes(
                $user->getEmail(),
                'R365: Know your tools - notes',
            );
            $userKyt->setNotesSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getRewardsLearned()) &&
            (false === $userKyt->getRewardsSent()) &&
            (0 === count($user->getRewardsAll()))
        ) {
            $this->emailService->sendUserKytRewards(
                $user->getEmail(),
                'R365: Know your tools - rewards',
            );
            $userKyt->setRewardsSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getProjectsLearned()) &&
            (false === $userKyt->getProjectsSent()) &&
            (0 === count($user->getProjectsAll()))
        ) {
            $this->emailService->sendUserKytProjects(
                $user->getEmail(),
                'R365: Know your tools - projects',
            );
            $userKyt->setProjectsSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getGoalsLearned()) &&
            (false === $userKyt->getGoalsSent()) &&
            (0 === count($user->getGoalsAll()))
        ) {
            $this->emailService->sendUserKytGoals(
                $user->getEmail(),
                'R365: Know your tools - goals',
            );
            $userKyt->setGoalsSent(true);
            $userKyt->setDateOfLastMessage($date);
        }

        $this->userKytManager->save($userKyt, (string) $user);

        return $user;
    }

    public function rewardUserKyt(UserKyt $userKyt): bool
    {
        $user = $userKyt->getUser();
        $used = $this->promotionService->applySystemPromotion(
            'REWARD10',
            $user
        );

        $this->userKytManager->save($userKyt, (string) $user);

        return $used;
    }
}