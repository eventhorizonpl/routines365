<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\{User, UserKyt};
use App\Manager\UserKytManager;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserKytService
{
    public function __construct(
        private EmailService $emailService,
        private PaginatorInterface $paginator,
        private PromotionService $promotionService,
        private TranslatorInterface $translator,
        private UserKytManager $userKytManager,
        private UserRepository $userRepository
    ) {
    }

    public function nurture(): self
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

        if ((false === $userKyt->getBasicConfigurationLearned())
            && (false === $userKyt->getBasicConfigurationSent())
            && (null === $user->getProfile()->getTimeZone())
        ) {
            $this->emailService->sendUserKytBasicConfiguration(
                $user->getEmail(),
                $this->translator->trans('R365: Know your tools - basic configuration'),
                [
                    'recipient_first_name' => $user->getProfile()->getFirstName(),
                ]
            );
            $userKyt->setBasicConfigurationSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getRoutinesLearned())
            && (false === $userKyt->getRoutinesSent())
            && (0 === \count($user->getRoutinesAll()))
        ) {
            $this->emailService->sendUserKytRoutines(
                $user->getEmail(),
                $this->translator->trans('R365: Know your tools - routines'),
                [
                    'recipient_first_name' => $user->getProfile()->getFirstName(),
                ]
            );
            $userKyt->setRoutinesSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getRemindersLearned())
            && (false === $userKyt->getRemindersSent())
            && (0 === \count($user->getRemindersAll()))
        ) {
            $this->emailService->sendUserKytReminders(
                $user->getEmail(),
                $this->translator->trans('R365: Know your tools - reminders'),
                [
                    'recipient_first_name' => $user->getProfile()->getFirstName(),
                ]
            );
            $userKyt->setRemindersSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getCompletingRoutinesLearned())
            && (false === $userKyt->getCompletingRoutinesSent())
            && (0 === \count($user->getCompletedRoutinesAll()))
        ) {
            $this->emailService->sendUserKytCompletingRoutines(
                $user->getEmail(),
                $this->translator->trans('R365: Know your tools - completing routines'),
                [
                    'recipient_first_name' => $user->getProfile()->getFirstName(),
                ]
            );
            $userKyt->setCompletingRoutinesSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getNotesLearned())
            && (false === $userKyt->getNotesSent())
            && (0 === \count($user->getNotesAll()))
        ) {
            $this->emailService->sendUserKytNotes(
                $user->getEmail(),
                $this->translator->trans('R365: Know your tools - notes'),
                [
                    'recipient_first_name' => $user->getProfile()->getFirstName(),
                ]
            );
            $userKyt->setNotesSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getRewardsLearned())
            && (false === $userKyt->getRewardsSent())
            && (0 === \count($user->getRewardsAll()))
        ) {
            $this->emailService->sendUserKytRewards(
                $user->getEmail(),
                $this->translator->trans('R365: Know your tools - rewards'),
                [
                    'recipient_first_name' => $user->getProfile()->getFirstName(),
                ]
            );
            $userKyt->setRewardsSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getProjectsLearned())
            && (false === $userKyt->getProjectsSent())
            && (0 === \count($user->getProjectsAll()))
        ) {
            $this->emailService->sendUserKytProjects(
                $user->getEmail(),
                $this->translator->trans('R365: Know your tools - projects'),
                [
                    'recipient_first_name' => $user->getProfile()->getFirstName(),
                ]
            );
            $userKyt->setProjectsSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getGoalsLearned())
            && (false === $userKyt->getGoalsSent())
            && (0 === \count($user->getGoalsAll()))
        ) {
            $this->emailService->sendUserKytGoals(
                $user->getEmail(),
                $this->translator->trans('R365: Know your tools - goals'),
                [
                    'recipient_first_name' => $user->getProfile()->getFirstName(),
                ]
            );
            $userKyt->setGoalsSent(true);
            $userKyt->setDateOfLastMessage($date);
        } elseif ((false === $userKyt->getTestimonialRequestSent())
            && (\count($user->getCompletedRoutinesAll()) >= 50)
        ) {
            $this->emailService->sendRequestForTestimonial(
                $user->getEmail(),
                $this->translator->trans('R365: Request for a testimonial'),
                [
                    'recipient_first_name' => $user->getProfile()->getFirstName(),
                ]
            );
            $userKyt->setTestimonialRequestSent(true);
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
