<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\{User, UserKpi};
use App\Enum\UserKpiTypeEnum;
use App\Factory\UserKpiFactory;
use App\Manager\UserKpiManager;
use App\Repository\{UserKpiRepository, UserRepository};
use DateTimeImmutable;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserKpiService
{
    public function __construct(
        private EmailService $emailService,
        private PaginatorInterface $paginator,
        private TranslatorInterface $translator,
        private UserKpiFactory $userKpiFactory,
        private UserKpiManager $userKpiManager,
        private UserKpiRepository $userKpiRepository,
        private UserRepository $userRepository
    ) {
    }

    public function create(
        string $type,
        User $user,
        UserKpi $previousUserKpi = null
    ): UserKpi {
        $date = new DateTimeImmutable();
        $userKpi = $this->userKpiFactory->createUserKpiWithRequired(
            \count($user->getAccount()->getAccountOperations()),
            \count($user->getRewardsAwarded()),
            \count($user->getGoalsCompleted()),
            \count($user->getProjectsCompleted()),
            \count($user->getCompletedRoutines()),
            \count($user->getContacts()),
            $date,
            \count($user->getGoals()),
            \count($user->getNotes()),
            \count($user->getProjects()),
            \count($user->getReminders()),
            \count($user->getRewards()),
            \count($user->getRoutines()),
            \count($user->getSavedEmails()),
            $type,
            \count($user->getUserQuestionnaires())
        );
        $userKpi->setUser($user);
        if (null !== $previousUserKpi) {
            $userKpi->setPreviousUserKpi($previousUserKpi);
        }
        $this->userKpiManager->save($userKpi);

        return $userKpi;
    }

    public function run(string $type): self
    {
        $page = 1;
        $limit = 5;

        $usersQuery = $this->userRepository->findForKpi();

        do {
            $users = $this->paginator->paginate($usersQuery, $page, $limit);

            foreach ($users as $user) {
                $previousUserKpi = $this->userKpiRepository->findOneByTypeAndUser(
                    $type,
                    $user
                );
                $userKpi = $this->create(
                    $type,
                    $user,
                    $previousUserKpi
                );
                if (\in_array($type, [UserKpiTypeEnum::ANNUALLY, UserKpiTypeEnum::MONTHLY, UserKpiTypeEnum::WEEKLY], true)) {
                    $this->emailService->sendUserKpi(
                        $user->getEmail(),
                        $this->translator->trans('R365: Your type statistics', ['type' => $userKpi->getType()]),
                        [
                            'recipient_first_name' => $user->getProfile()->getFirstName(),
                            'user_kpi' => $userKpi,
                        ]
                    );
                }
            }
            ++$page;
        } while ($users->getCurrentPageNumber() <= $users->getPageCount());

        return $this;
    }
}
