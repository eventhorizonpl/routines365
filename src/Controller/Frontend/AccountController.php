<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Account;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/settings/account", name="frontend_account_")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/", name="show", methods={"GET"})
     */
    public function show(): Response
    {
        $account = $this->getUser()->getAccount();

        return $this->render('frontend/account/show.html.twig', [
            'account' => $account,
        ]);
    }
}
