<?php

namespace App\Controller\Admin;

use App\Entity\SavedEmail;
use App\Entity\User;
use App\Repository\SavedEmailRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/saved-email", name="admin_saved_email_")
 */
class SavedEmailController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        Request $request,
        SavedEmailRepository $savedEmailRepository
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim($request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => trim($request->query->get('type')),
        ];

        $savedEmailsQuery = $savedEmailRepository->findByParametersForAdmin($parameters);
        $savedEmails = $paginator->paginate(
            $savedEmailsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/saved_email/index.html.twig', [
            'parameters' => $parameters,
            'saved_emails' => $savedEmails,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(SavedEmail $savedEmail): Response
    {
        return $this->render('admin/saved_email/show.html.twig', [
            'saved_email' => $savedEmail,
        ]);
    }
}
