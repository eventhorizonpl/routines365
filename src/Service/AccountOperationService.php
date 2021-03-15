<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Account;
use App\Entity\AccountOperation;
use App\Entity\ReminderMessage;
use App\Exception\AccountException;
use App\Factory\AccountOperationFactory;
use App\Manager\AccountOperationManager;

class AccountOperationService
{
    public function __construct(
        private AccountOperationFactory $accountOperationFactory,
        private AccountOperationManager $accountOperationManager
    ) {
    }

    public function deposit(
        Account $account,
        string $description,
        int $notifications,
        int $smsNotifications,
        bool $topupReferrerAccount = true
    ): AccountOperation {
        if ((true === $account->canDepositNotifications($notifications))
            && (true === $account->canDepositSmsNotifications($smsNotifications))) {
            $accountOperation = $this->accountOperationFactory->createAccountOperationWithRequired(
                $description,
                $notifications,
                $smsNotifications,
                AccountOperation::TYPE_DEPOSIT
            );
            $accountOperation->setAccount($account);
            $this->accountOperationManager->save($accountOperation);

            if ((null !== $account->getUsers()->first()->getReferrer()) && (true === $topupReferrerAccount)) {
                $referrerAccount = $account->getUsers()->first()->getReferrer()->getAccount();
                $referrerNotifications = (int) ($notifications * Account::TOPUP_REFERRER_ACCOUNT_MULTIPLIER);
                if ((0 < $notifications) && (0 === $referrerNotifications)) {
                    $referrerNotifications = 1;
                }
                $referrerSmsNotifications = (int) ($smsNotifications * Account::TOPUP_REFERRER_ACCOUNT_MULTIPLIER);
                if ((0 < $smsNotifications) && (0 === $referrerSmsNotifications)) {
                    $referrerSmsNotifications = 1;
                }
                $referrerAccountOperation = $this->deposit(
                    $referrerAccount,
                    'Referrer bonus',
                    $referrerNotifications,
                    $referrerSmsNotifications,
                    false
                );
            }

            return $accountOperation;
        }
        throw new AccountException();
    }

    public function withdraw(
        Account $account,
        string $description,
        int $notifications,
        int $smsNotifications,
        ReminderMessage $reminderMessage = null
    ): AccountOperation {
        if ((true === $account->canWithdrawNotifications($notifications))
            && (true === $account->canWithdrawSmsNotifications($smsNotifications))) {
            $accountOperation = $this->accountOperationFactory->createAccountOperationWithRequired(
                $description,
                $notifications,
                $smsNotifications,
                AccountOperation::TYPE_WITHDRAW
            );
            $accountOperation->setAccount($account);

            if (null !== $reminderMessage) {
                $accountOperation->setReminderMessage($reminderMessage);
            }

            $this->accountOperationManager->save($accountOperation);

            return $accountOperation;
        }
        throw new AccountException();
    }
}
