<?php

namespace App\Controller\Frontend;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\Frontend\ProfileType;
use App\Manager\ProfileManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/profile", name="frontend_profile_")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="show", methods={"GET"})
     */
    public function show(): Response
    {
        $profile = $this->getUser()->getProfile();

        return $this->render('frontend/profile/show.html.twig', [
            'profile' => $profile,
        ]);
    }

    /**
     * @Route("/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        ProfileManager $profileManager,
        Request $request
    ): Response {
        $profile = $this->getUser()->getProfile();

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $profileManager->save($profile, $this->getUser());

            return $this->redirectToRoute('frontend_profile_show');
        }

        return $this->render('frontend/profile/edit.html.twig', [
            'form' => $form->createView(),
            'profile' => $profile,
        ]);
    }
}
