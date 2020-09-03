<?php

namespace App\Service;

use App\Entity\Account;
use App\Entity\AccountOperation;
use App\Entity\ReminderMessage;
use App\Exception\AccountException;
use App\Factory\AccountOperationFactory;
use App\Manager\AccountOperationManager;

class AccountOperationService
{
    private AccountOperationFactory $accountOperationFactory;
    private AccountOperationManager $accountOperationManager;

    public function __construct(
        AccountOperationFactory $accountOperationFactory,
        AccountOperationManager $accountOperationManager
    ) {
        $this->accountOperationFactory = $accountOperationFactory;
        $this->accountOperationManager = $accountOperationManager;
    }

    public function deposit(
        Account $account,
        string $description,
        int $emailNotifications,
        int $smsNotifications,
        bool $topupReferrerAccount = true
    ): AccountOperation {
        if ((true === $account->canDepositEmailNotifications($emailNotifications)) &&
            (true === $account->canDepositSmsNotifications($smsNotifications))) {
            $accountOperation = $this->accountOperationFactory->createAccountOperationWithRequired(
                $description,
                $emailNotifications,
                $smsNotifications,
                AccountOperation::TYPE_DEPOSIT
            );
            $accountOperation->setAccount($account);
            $this->accountOperationManager->save($accountOperation);

            if ((null !== $account->getUser()->getReferrer()) && (true === $topupReferrerAccount)) {
                $referrerAccount = $account->getUser()->getReferrer()->getAccount();
                $referrerEmailNotifications = (int) ($emailNotifications * Account::TOPUP_REFERRER_ACCOUNT_MULTIPLIER);
                if ((0 < $emailNotifications) && (0 === $referrerEmailNotifications)) {
                    $referrerEmailNotifications = 1;
                }
                $referrerSmsNotifications = (int) ($smsNotifications * Account::TOPUP_REFERRER_ACCOUNT_MULTIPLIER);
                if ((0 < $smsNotifications) && (0 === $referrerSmsNotifications)) {
                    $referrerSmsNotifications = 1;
                }
                $referrerAccountOperation = $this->deposit(
                    $referrerAccount,
                    'Referrer bonus',
                    $referrerEmailNotifications,
                    $referrerSmsNotifications,
                    false
                );
            }

            return $accountOperation;
        } else {
            throw new AccountException();
        }
    }

    public function withdraw(
        Account $account,
        string $description,
        int $emailNotifications,
        int $smsNotifications,
        ReminderMessage $reminderMessage = null
    ): AccountOperation {
        if ((true === $account->canWithdrawEmailNotifications($emailNotifications)) &&
            (true === $account->canWithdrawSmsNotifications($smsNotifications))) {
            $accountOperation = $this->accountOperationFactory->createAccountOperationWithRequired(
                $description,
                $emailNotifications,
                $smsNotifications,
                AccountOperation::TYPE_WITHDRAW
            );
            $accountOperation->setAccount($account);

            if (null !== $reminderMessage) {
                $accountOperation->setReminderMessage($reminderMessage);
            }

            $this->accountOperationManager->save($accountOperation);

            return $accountOperation;
        } else {
            throw new AccountException();
        }
    }
}
