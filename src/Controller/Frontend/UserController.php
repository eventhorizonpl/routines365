<?php

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\Security\ChangePasswordFormType;
use App\Manager\UserManager;
use App\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/settings/", name="frontend_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/change-password", name="change_password", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        UserManager $userManager,
        UserService $userService
    ): Response {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordFormType::class, $user);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            if (null !== $form->get('plainPassword')->getData()) {
                $user = $userService->encodePassword($user, $form->get('plainPassword')->getData());
            }
            $userManager->save($user, $this->getUser());

            return $this->redirectToRoute('frontend_profile_show');
        }

        return $this->render('frontend/user/change_password.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}