<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\UserRoleEnum;
use App\Factory\UserFactory;
use App\Form\Admin\{UserLeadType, UserType};
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Service\{AccountOperationService, EmailService, UserService};
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(UserRoleEnum::ROLE_ADMIN)]
#[Route('/admin/user', name: 'admin_user_')]
class UserController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        PaginatorInterface $paginator,
        Request $request,
        UserRepository $userRepository
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $usersQuery = $userRepository->findByParametersForAdmin($parameters);
        $users = $paginator->paginate(
            $usersQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $users->getTotalItemCount();

        return $this->render('admin/user/index.html.twig', [
            'parameters' => $parameters,
            'users' => $users,
        ]);
    }

    #[Route('/new', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        Request $request,
        UserFactory $userFactory,
        UserManager $userManager,
        UserService $userService
    ): Response {
        $user = $userFactory->createUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $user = $userService->encodePassword($user, $form->get('plainPassword')->getData());
            $userManager->save($user, (string) $this->getUser());

            return $this->redirectToRoute('admin_user_show', [
                'uuid' => $user->getUuid(),
            ]);
        }

        return $this->render('admin/user/new.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/new-lead', methods: ['GET', 'POST'], name: 'new_lead')]
    public function newLead(
        AccountOperationService $accountOperationService,
        EmailService $emailService,
        Request $request,
        TranslatorInterface $translator,
        UserFactory $userFactory,
        UserManager $userManager,
        UserService $userService
    ): Response {
        $user = $userFactory->createUserLead();
        $form = $this->createForm(UserLeadType::class, $user);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $password = substr((string) Uuid::v4(), 24);
            $user = $userService->encodePassword($user, $password);
            $userManager->save($user, (string) $this->getUser());

            $accountOperation = $accountOperationService->deposit(
                $user->getAccount(),
                'Free notifications',
                $form->get('notifications')->getData(),
                $form->get('smsNotifications')->getData()
            );

            $emailService->sendNewLead(
                $user->getEmail(),
                $translator->trans('R365: Your new Routines365 account is now active.'),
                [
                    'email_address' => $user->getEmail(),
                    'password' => $password,
                    'recipient_first_name' => $user->getProfile()->getFirstName(),
                ]
            );

            return $this->redirectToRoute('admin_user_show', [
                'uuid' => $user->getUuid(),
            ]);
        }

        return $this->render('admin/user/new_lead.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{uuid}/disable-2fa', methods: ['GET'], name: 'disable_2fa')]
    public function disable2fa(User $user, UserManager $userManager): Response
    {
        $user->setGoogleAuthenticatorSecret(null);
        $userManager->save($user, (string) $user);

        return $this->redirectToRoute('admin_user_show', [
            'uuid' => $user->getUuid(),
        ]);
    }

    #[Route('/{uuid}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        Request $request,
        User $user,
        UserManager $userManager,
        UserService $userService
    ): Response {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            if (null !== $form->get('plainPassword')->getData()) {
                $user = $userService->encodePassword($user, $form->get('plainPassword')->getData());
            }
            $userManager->save($user, (string) $this->getUser());

            return $this->redirectToRoute('admin_user_show', [
                'uuid' => $user->getUuid(),
            ]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[IsGranted(UserRoleEnum::ROLE_SUPER_ADMIN)]
    #[Route('/{uuid}', methods: ['DELETE'], name: 'delete')]
    public function delete(
        Request $request,
        User $user,
        UserManager $userManager
    ): Response {
        if (true === $this->isCsrfTokenValid(
            sprintf(
                'delete%s',
                (string) $user->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $userManager->softDelete($user, (string) $this->getUser());
        }

        return $this->redirectToRoute('admin_user_index');
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        User $user,
        UserManager $userManager
    ): Response {
        $userManager->undelete($user);

        return $this->redirectToRoute('admin_user_show', [
            'uuid' => $user->getUuid(),
        ]);
    }
}
