<?php

namespace App\Controller\Admin;

use App\Entity\Reminder;
use App\Entity\User;
use App\Manager\ReminderManager;
use App\Repository\ReminderRepository;
use App\Util\DateTimeImmutableUtil;
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
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim($request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $remindersQuery = $reminderRepository->findByParametersForAdmin($parameters);
        $reminders = $paginator->paginate(
            $remindersQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/reminder/index.html.twig', [
            'parameters' => $parameters,
            'reminders' => $reminders,
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

    /**
     * @Route("/{uuid}/undelete", name="undelete", methods={"GET"})
     */
    public function undelete(
        Reminder $reminder,
        ReminderManager $reminderManager
    ): Response {
        $reminderManager->undelete($reminder);

        return $this->redirectToRoute('admin_reminder_show', [
            'uuid' => $reminder->getUuid(),
        ]);
    }

    /**
     * @Route("/{uuid}/unlock", name="unlock", methods={"GET"})
     */
    public function unlock(
        Reminder $reminder,
        ReminderManager $reminderManager
    ): Response {
        $reminderManager->unlock($reminder);

        return $this->redirectToRoute('admin_reminder_show', [
            'uuid' => $reminder->getUuid(),
        ]);
    }
}
