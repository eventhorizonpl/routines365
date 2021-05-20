<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Entity\User;
use App\Enum\{UserRoleEnum, UserTypeEnum};
use App\Factory\UserFactory;
use App\Form\Security\RegistrationFormType;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Resource\ConfigResource;
use App\Security\{EmailVerifier, LoginFormAuthenticator};
use App\Service\{AccountOperationService, PromotionService, UserService};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[Route('/', name: 'security_')]
class RegistrationController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

    #[Route('/register', methods: ['GET', 'POST'], name: 'register')]
    public function register(
        AccountOperationService $accountOperationService,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator,
        PromotionService $promotionService,
        Request $request,
        UserFactory $userFactory,
        UserManager $userManager,
        UserRepository $userRepository,
        UserService $userService
    ): Response {
        if (true !== ConfigResource::REGISTRATION_ENABLED) {
            return $this->redirectToRoute('frontend_home');
        }

        $promotionCode = $request->query->get('promotion_code');
        $referrerCode = $request->query->get('referrer_code');
        $user = $userFactory->createUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $user = $userService->encodePassword($user, $form->get('plainPassword')->getData());
            $user->setIsEnabled(true);
            $user->setRoles([UserRoleEnum::ROLE_USER]);
            $user->setType(UserTypeEnum::PROSPECT);

            if ((null !== $referrerCode) || ('' !== $referrerCode)) {
                $referrer = $userRepository->findOneBy([
                    'referrerCode' => $referrerCode,
                ]);

                if (null !== $referrer) {
                    $user->setReferrer($referrer);
                }
            }

            $userManager->save($user);

            $account = $user->getAccount();
            $notifications = 10;
            if (true === $account->canDepositNotifications($notifications)) {
                $accountOperation = $accountOperationService->deposit(
                    $account,
                    '+10 notifications promotion for new registration',
                    $notifications,
                    0
                );
            }

            if ((null !== $promotionCode) && ('' !== $promotionCode)) {
                $used = $promotionService->applyNewAccountPromotion(
                    $promotionCode,
                    $user
                );
            }

            $this->emailVerifier->sendEmailConfirmation($user);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        }

        return $this->render('security/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', methods: ['GET'], name: 'verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('frontend_home');
        }

        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('frontend_routine_index');
    }
}
