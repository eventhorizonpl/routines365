<?php

namespace App\Controller\Security;

use App\Config;
use App\Entity\User;
use App\Factory\UserFactory;
use App\Form\Security\RegistrationFormType;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

/**
 * @Route("/", name="security_")
 */
class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator,
        Request $request,
        UserFactory $userFactory,
        UserManager $userManager,
        UserRepository $userRepository,
        UserService $userService
    ): Response {
        if (true !== Config::REGISTRATION_ENABLED) {
            return $this->redirectToRoute('frontend_home');
        }

        $referrerCode = $request->query->get('referrer_code');
        $user = $userFactory->createUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            if ((null !== $referrerCode) or ('' !== $referrerCode)) {
                $referrer = $userRepository->findOneBy([
                    'referrerCode' => $referrerCode,
                ]);
            } else {
                $referrer = null;
            }

            $user = $userService->encodePassword($user, $form->get('plainPassword')->getData());
            $user->setIsEnabled(true);
            $user->setRoles([User::ROLE_USER]);

            if (null !== $referrer) {
                $user->setReferrer($referrer);
            }

            $userManager->save($user);

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

    /**
     * @Route("/verify/email", name="verify_email")
     */
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
