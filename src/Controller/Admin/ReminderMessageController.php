<?php

namespace App\Controller\Admin;

use App\Entity\ReminderMessage;
use App\Entity\User;
use App\Manager\ReminderMessageManager;
use App\Repository\ReminderMessageRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/reminder-message", name="admin_reminder_message_")
 */
class ReminderMessageController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        ReminderMessageRepository $reminderMessageRepository,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim($request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $reminderMessagesQuery = $reminderMessageRepository->findByParametersForAdmin($parameters);
        $reminderMessages = $paginator->paginate(
            $reminderMessagesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/reminder_message/index.html.twig', [
            'parameters' => $parameters,
            'reminder_messages' => $reminderMessages,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(ReminderMessage $reminderMessage): Response
    {
        return $this->render('admin/reminder_message/show.html.twig', [
            'reminder_message' => $reminderMessage,
        ]);
    }

    /**
     * @Route("/{uuid}/undelete", name="undelete", methods={"GET"})
     */
    public function undelete(
        ReminderMessage $reminderMessage,
        ReminderMessageManager $reminderMessageManager
    ): Response {
        $reminderMessageManager->undelete($reminderMessage);

        return $this->redirectToRoute('admin_reminder_message_show', [
            'uuid' => $reminderMessage->getUuid(),
        ]);
    }
}
