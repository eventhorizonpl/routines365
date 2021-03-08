<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\Frontend\ProfilePhoneVerificationCodeType;
use App\Form\Frontend\ProfileType;
use App\Manager\ProfileManager;
use App\Resource\KytResource;
use App\Service\Sms\SmsService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(User::ROLE_USER)]
#[Route('/settings/profile', name: 'frontend_profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'show')]
    public function show(Request $request): Response
    {
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));
        $profile = $this->getUser()->getProfile();

        return $this->render('frontend/profile/show.html.twig', [
            'know_your_tools' => $knowYourTools,
            'profile' => $profile,
        ]);
    }

    #[Route('/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        ProfileManager $profileManager,
        Request $request,
        SmsService $smsService,
        TranslatorInterface $translator
    ): Response {
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));
        $profile = $this->getUser()->getProfile();

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $profileManager->save($profile, (string) $this->getUser());

            if ((false === $profile->getIsVerified()) &&
                (null !== $profile->getPhone()) &&
                (null !== $profile->getPhoneVerificationCode()) &&
                (5 > $profile->getNumberOfPhoneVerificationTries())
            ) {
                $this->addFlash(
                    'success',
                    $translator->trans('We have sent you a verification code on your phone!')
                );

                $smsService->sendPhoneVerificationCode($profile->getPhoneString(), [
                    'phone_verification_code' => $profile->getPhoneVerificationCode(),
                ]);

                return $this->redirectToRoute('frontend_profile_phone_verification_code');
            } elseif (5 <= $profile->getNumberOfPhoneVerificationTries()) {
                $this->addFlash(
                    'danger',
                    $translator->trans('You exceeded your phone number verification attempts!')
                );
            }

            if ($knowYourTools) {
                return $this->redirectToRoute('frontend_profile_show', [
                    'know_your_tools' => KytResource::BASIC_CONFIGURATION_FINISH,
                ]);
            } else {
                return $this->redirectToRoute('frontend_profile_show');
            }
        }

        return $this->render('frontend/profile/edit.html.twig', [
            'form' => $form->createView(),
            'know_your_tools' => $knowYourTools,
            'profile' => $profile,
        ]);
    }

    #[Route('/phone-verification-code', methods: ['GET', 'POST'], name: 'phone_verification_code')]
    public function phoneVerificationCode(
        ProfileManager $profileManager,
        Request $request,
        SmsService $smsService,
        TranslatorInterface $translator
    ): Response {
        $profile = $this->getUser()->getProfile();
        if (true === $profile->getIsVerified()) {
            $this->addFlash(
                'success',
                $translator->trans('Your phone number is already verified!')
            );

            return $this->redirectToRoute('frontend_profile_show');
        }

        $form = $this->createForm(ProfilePhoneVerificationCodeType::class);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $profilePhoneVerificationCodeFormModel = $form->getData();
            if ($profile->getPhoneVerificationCode() === $profilePhoneVerificationCodeFormModel->phoneVerificationCode) {
                $profile->setIsVerified(true);
                $profile->setNumberOfPhoneVerificationTries(null);
                $profile->setPhoneMd5(md5($profile->getPhoneString()));
                $profile->setPhoneVerificationCode(null);
                $profileManager->save($profile, (string) $this->getUser());

                return $this->redirectToRoute('frontend_profile_show');
            }

            $profileManager->save($profile, (string) $this->getUser());

            if ((false === $profile->getIsVerified()) &&
                (null !== $profile->getPhoneVerificationCode()) &&
                (5 > $profile->getNumberOfPhoneVerificationTries())
            ) {
                $this->addFlash(
                    'success',
                    $translator->trans('We have sent you a verification code on your phone!')
                );

                $smsService->sendPhoneVerificationCode($profile->getPhoneString(), [
                    'phone_verification_code' => $profile->getPhoneVerificationCode(),
                ]);
            } elseif (5 <= $profile->getNumberOfPhoneVerificationTries()) {
                $this->addFlash(
                    'danger',
                    $translator->trans('You exceeded your phone number verification attempts!')
                );
            }

            return $this->redirectToRoute('frontend_profile_phone_verification_code');
        }

        return $this->render('frontend/profile/phone_verification_code.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
