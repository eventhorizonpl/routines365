<?php

namespace App\Service;

use App\Entity\Account;
use App\Entity\AccountOperation;
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
        int $smsNotifications
    ): AccountOperation {
        $accountOperation = $this->accountOperationFactory->createAccountOperationWithRequired(
            $description,
            $emailNotifications,
            $smsNotifications,
            AccountOperation::TYPE_DEPOSIT
        );
        $accountOperation->setAccount($account);
        $this->accountOperationManager->save($accountOperation);

        return $accountOperation;
    }
}
