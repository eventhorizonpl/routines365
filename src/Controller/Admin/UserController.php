<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Form\Admin\UserType;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Service\UserService;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/user", name="admin_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        Request $request,
        UserRepository $userRepository
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim($request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $queryResult = $userRepository->findByParametersForAdmin($parameters);
        $users = $paginator->paginate(
            $queryResult,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/user/index.html.twig', [
            'parameters' => $parameters,
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
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
            $userManager->save($user, $this->getUser());

            return $this->redirectToRoute('admin_user_show', [
                'uuid' => $user->getUuid(),
            ]);
        }

        return $this->render('admin/user/new.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
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
            $userManager->save($user, $this->getUser());

            return $this->redirectToRoute('admin_user_show', [
                'uuid' => $user->getUuid(),
            ]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @IsGranted(User::ROLE_SUPER_ADMIN)
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Request $request,
        User $user,
        UserManager $userManager
    ): Response {
        if (true === $this->isCsrfTokenValid(
            'delete'.$user->getUuid(),
            $request->request->get('_token')
        )) {
            $userManager->softDelete($user, $this->getUser());
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
