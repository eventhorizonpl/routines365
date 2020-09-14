<?php

namespace App\Controller\Admin;

use App\Entity\SentReminder;
use App\Entity\User;
use App\Manager\SentReminderManager;
use App\Repository\SentReminderRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/sent-reminder", name="admin_sent_reminder_")
 */
class SentReminderController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        SentReminderRepository $sentReminderRepository,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $sentRemindersQuery = $sentReminderRepository->findByParametersForAdmin($parameters);
        $sentReminders = $paginator->paginate(
            $sentRemindersQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/sent_reminder/index.html.twig', [
            'parameters' => $parameters,
            'sent_reminders' => $sentReminders,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(SentReminder $sentReminder): Response
    {
        return $this->render('admin/sent_reminder/show.html.twig', [
            'sent_reminder' => $sentReminder,
        ]);
    }

    /**
     * @Route("/{uuid}/undelete", name="undelete", methods={"GET"})
     */
    public function undelete(
        SentReminder $sentReminder,
        SentReminderManager $sentReminderManager
    ): Response {
        $sentReminderManager->undelete($sentReminder);

        return $this->redirectToRoute('admin_sent_reminder_show', [
            'uuid' => $sentReminder->getUuid(),
        ]);
    }
}
