<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Enum\UserRoleEnum;
use App\Repository\AccountOperationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(UserRoleEnum::ROLE_USER)]
#[Route('/settings/account', name: 'frontend_account_')]
class AccountController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'show')]
    public function show(
        AccountOperationRepository $accountOperationRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'query' => trim((string) $request->query->get('q')),
        ];

        $account = $this->getUser()->getAccount();
        $accountOperationsQuery = $accountOperationRepository->findByParametersForFrontend($this->getUser(), $parameters);
        $accountOperations = $paginator->paginate(
            $accountOperationsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('frontend/account/show.html.twig', [
            'account' => $account,
            'account_operations' => $accountOperations,
        ]);
    }
}
