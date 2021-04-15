<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\{ReminderMessage, User};
use App\Manager\ReminderMessageManager;
use App\Repository\ReminderMessageRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(User::ROLE_ADMIN)]
#[Route('/admin/reminder-message', name: 'admin_reminder_message_')]
class ReminderMessageController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        PaginatorInterface $paginator,
        ReminderMessageRepository $reminderMessageRepository,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $reminderMessagesQuery = $reminderMessageRepository->findByParametersForAdmin($parameters);
        $reminderMessages = $paginator->paginate(
            $reminderMessagesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $reminderMessages->getTotalItemCount();

        return $this->render('admin/reminder_message/index.html.twig', [
            'parameters' => $parameters,
            'reminder_messages' => $reminderMessages,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(ReminderMessage $reminderMessage): Response
    {
        return $this->render('admin/reminder_message/show.html.twig', [
            'reminder_message' => $reminderMessage,
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
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
