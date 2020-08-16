<?php

namespace App\Service;

use App\Entity\Kpi;
use App\Factory\KpiFactory;
use App\Manager\KpiManager;
use App\Repository\AccountOperationRepository;
use App\Repository\AccountRepository;
use App\Repository\GoalRepository;
use App\Repository\NoteRepository;
use App\Repository\ProfileRepository;
use App\Repository\QuoteRepository;
use App\Repository\ReminderMessageRepository;
use App\Repository\ReminderRepository;
use App\Repository\RoutineRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;

class KpiService
{
    private AccountRepository $accountRepository;
    private AccountOperationRepository $accountOperationRepository;
    private GoalRepository $goalRepository;
    private KpiFactory $kpiFactory;
    private KpiManager $kpiManager;
    private NoteRepository $noteRepository;
    private ProfileRepository $profileRepository;
    private QuoteRepository $quoteRepository;
    private ReminderMessageRepository $reminderMessageRepository;
    private ReminderRepository $reminderRepository;
    private RoutineRepository $routineRepository;
    private UserRepository $userRepository;

    public function __construct(
        AccountRepository $accountRepository,
        AccountOperationRepository $accountOperationRepository,
        GoalRepository $goalRepository,
        KpiFactory $kpiFactory,
        KpiManager $kpiManager,
        NoteRepository $noteRepository,
        ProfileRepository $profileRepository,
        QuoteRepository $quoteRepository,
        ReminderMessageRepository $reminderMessageRepository,
        ReminderRepository $reminderRepository,
        RoutineRepository $routineRepository,
        UserRepository $userRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->accountOperationRepository = $accountOperationRepository;
        $this->goalRepository = $goalRepository;
        $this->kpiFactory = $kpiFactory;
        $this->kpiManager = $kpiManager;
        $this->noteRepository = $noteRepository;
        $this->profileRepository = $profileRepository;
        $this->quoteRepository = $quoteRepository;
        $this->reminderMessageRepository = $reminderMessageRepository;
        $this->reminderRepository = $reminderRepository;
        $this->routineRepository = $routineRepository;
        $this->userRepository = $userRepository;
    }

    public function create(): Kpi
    {
        $date = new DateTimeImmutable();
        $kpi = $this->kpiFactory->createKpiWithRequired(
            $this->accountRepository->count([]),
            $this->accountOperationRepository->count([]),
            $date,
            $this->goalRepository->count([]),
            $this->noteRepository->count([]),
            $this->profileRepository->count([]),
            $this->quoteRepository->count([]),
            $this->reminderRepository->count([]),
            $this->reminderMessageRepository->count([]),
            $this->routineRepository->count([]),
            $this->userRepository->count([])
        );
        $this->kpiManager->save($kpi);

        return $kpi;
    }
}
