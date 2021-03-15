<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Account;
use App\Entity\AccountOperation;
use App\Entity\User;
use App\Manager\AccountOperationManager;
use App\Repository\AccountOperationRepository;
use App\Service\AccountOperationService;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(User::ROLE_ADMIN)]
#[Route('/admin/account-operation', name: 'admin_account_operation_')]
class AccountOperationController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        AccountOperationRepository $accountOperationRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $accountOperationsQuery = $accountOperationRepository->findByParametersForAdmin($parameters);
        $accountOperations = $paginator->paginate(
            $accountOperationsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $accountOperations->getTotalItemCount();

        return $this->render('admin/account_operation/index.html.twig', [
            'account_operations' => $accountOperations,
            'parameters' => $parameters,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(AccountOperation $accountOperation): Response
    {
        return $this->render('admin/account_operation/show.html.twig', [
            'account_operation' => $accountOperation,
        ]);
    }

    #[Route('/{uuid}/add-free-email', methods: ['GET'], name: 'add_free_email')]
    public function addFreeEmail(
        Account $account,
        AccountOperationService $accountOperationService
    ): Response {
        $notifications = 10;
        $smsNotifications = 0;

        if ((true === $account->canDepositNotifications($notifications))
            && (true === $account->canDepositSmsNotifications($smsNotifications))) {
            $accountOperation = $accountOperationService->deposit(
                $account,
                'Free email notifications',
                $notifications,
                $smsNotifications
            );

            return $this->redirectToRoute('admin_account_operation_show', [
                'uuid' => $accountOperation->getUuid(),
            ]);
        }

        return $this->redirectToRoute('admin_user_show', [
            'uuid' => $account->getUser()->getUuid(),
        ]);
    }

    #[Route('/{uuid}/add-free-sms', methods: ['GET'], name: 'add_free_sms')]
    public function addFreeSms(
        Account $account,
        AccountOperationService $accountOperationService
    ): Response {
        $notifications = 0;
        $smsNotifications = 10;

        if ((true === $account->canDepositNotifications($notifications))
            && (true === $account->canDepositSmsNotifications($smsNotifications))) {
            $accountOperation = $accountOperationService->deposit(
                $account,
                'Free sms notifications',
                $notifications,
                $smsNotifications
            );

            return $this->redirectToRoute('admin_account_operation_show', [
                'uuid' => $accountOperation->getUuid(),
            ]);
        }

        return $this->redirectToRoute('admin_user_show', [
            'uuid' => $account->getUser()->getUuid(),
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        AccountOperation $accountOperation,
        AccountOperationManager $accountOperationManager
    ): Response {
        $accountOperationManager->undelete($accountOperation);

        return $this->redirectToRoute('admin_account_operation_show', [
            'uuid' => $accountOperation->getUuid(),
        ]);
    }
}
