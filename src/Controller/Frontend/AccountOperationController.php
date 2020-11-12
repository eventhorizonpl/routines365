<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Repository\AccountOperationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/settings/account-operations", name="frontend_account_operation_")
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
            'query' => trim($request->query->get('q')),
        ];

        $accountOperationsQuery = $accountOperationRepository->findByParametersForFrontend($this->getUser(), $parameters);
        $accountOperations = $paginator->paginate(
            $accountOperationsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('frontend/account_operation/index.html.twig', [
            'account_operations' => $accountOperations,
        ]);
    }
}
