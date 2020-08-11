<?php

namespace App\Controller\Admin;

use App\Entity\Account;
use App\Entity\AccountOperation;
use App\Entity\User;
use App\Repository\AccountOperationRepository;
use App\Service\AccountOperationService;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/account-operation", name="admin_account_operation_")
 */
class AccountOperationController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        AccountOperationRepository $accountOperationRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim($request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $accountOperationsQuery = $accountOperationRepository->findByParametersForAdmin($parameters);
        $accountOperations = $paginator->paginate(
            $accountOperationsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/account_operation/index.html.twig', [
            'account_operations' => $accountOperations,
            'parameters' => $parameters,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(AccountOperation $accountOperation): Response
    {
        return $this->render('admin/account_operation/show.html.twig', [
            'account_operation' => $accountOperation,
        ]);
    }

    /**
     * @Route("/{uuid}/add-free-email", name="add_free_email", methods={"GET"})
     */
    public function addFreeEmail(
        Account $account,
        AccountOperationService $accountOperationService
    ): Response {
        $accountOperation = $accountOperationService->deposit(
            $account,
            'Free email notifications',
            10,
            0
        );

        return $this->redirectToRoute('admin_account_operation_show', [
            'uuid' => $accountOperation->getUuid(),
        ]);
    }

    /**
     * @Route("/{uuid}/add-free-sms", name="add_free_sms", methods={"GET"})
     */
    public function addFreeSms(
        Account $account,
        AccountOperationService $accountOperationService
    ): Response {
        $accountOperation = $accountOperationService->deposit(
            $account,
            'Free sms notifications',
            0,
            10
        );

        return $this->redirectToRoute('admin_account_operation_show', [
            'uuid' => $accountOperation->getUuid(),
        ]);
    }
}
