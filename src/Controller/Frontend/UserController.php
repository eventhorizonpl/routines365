<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\Frontend\ChangePasswordFormType;
use App\Manager\UserManager;
use App\Service\UserService;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\QrCode\QrCodeGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(User::ROLE_USER)]
#[Route('/settings', name: 'frontend_user_')]
class UserController extends AbstractController
{
    #[Route('/change-password', methods: ['GET', 'POST'], name: 'change_password')]
    public function changePassword(
        Request $request,
        TranslatorInterface $translator,
        UserManager $userManager,
        UserPasswordEncoderInterface $passwordEncoder,
        UserService $userService
    ): Response {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordFormType::class, $user);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            if (false === $passwordEncoder->isPasswordValid($user, $form->get('oldPassword')->getData())) {
                $this->addFlash(
                    'danger',
                    $translator->trans('Old password is not correct!')
                );

                return $this->redirectToRoute('frontend_user_change_password');
            }
            if (null !== $form->get('plainPassword')->getData()) {
                $user = $userService->encodePassword($user, $form->get('plainPassword')->getData());
            }
            $userManager->save($user, (string) $user);

            return $this->redirectToRoute('frontend_profile_show');
        }

        return $this->render('frontend/user/change_password.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/enable-2fa', methods: ['GET'], name: 'enable_2fa')]
    public function enable2fa(
        GoogleAuthenticatorInterface $googleAuthenticator,
        UserManager $userManager
    ): Response {
        $user = $this->getUser();

        if (null === $user->getGoogleAuthenticatorSecret()) {
            $secret = $googleAuthenticator->generateSecret();
            $user->setGoogleAuthenticatorSecret($secret);
            $userManager->save($user, (string) $user);
        }

        return $this->render('frontend/user/enable_2fa.html.twig');
    }

    #[Route('/disable-2fa', methods: ['GET'], name: 'disable_2fa')]
    public function disable2fa(
        UserManager $userManager
    ): Response {
        $user = $this->getUser();

        $user->setGoogleAuthenticatorSecret(null);
        $userManager->save($user, (string) $user);

        return $this->redirectToRoute('frontend_profile_show');
    }

    #[Route('/qr-code', methods: ['GET'], name: 'qr_code')]
    public function displayGoogleAuthenticatorQrCode(QrCodeGenerator $qrCodeGenerator): Response
    {
        $qrCode = $qrCodeGenerator->getGoogleAuthenticatorQrCode($this->getUser());

        return new Response($qrCode->writeString(), 200, ['Content-Type' => 'image/png']);
    }
}
