<?php

namespace App\Controller\Admin;

use App\Entity\Reminder;
use App\Entity\User;
use App\Repository\ReminderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/reminder", name="admin_reminder_")
 */
class ReminderController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        ReminderRepository $reminderRepository,
        Request $request
    ): Response {
        $parameters = [
            'query' => trim($request->query->get('q')),
        ];

        $queryResult = $reminderRepository->findByParametersForAdmin($parameters);
        $reminders = $paginator->paginate(
            $queryResult,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/reminder/index.html.twig', [
            'reminders' => $reminders,
            'parameters' => $parameters,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Reminder $reminder): Response
    {
        return $this->render('admin/reminder/show.html.twig', [
            'reminder' => $reminder,
        ]);
    }
}
