<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\{SentReminder, User};
use App\Enum\UserRoleEnum;
use App\Manager\SentReminderManager;
use App\Repository\SentReminderRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(UserRoleEnum::ROLE_ADMIN)]
#[Route('/admin/sent-reminder', name: 'admin_sent_reminder_')]
class SentReminderController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
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
        $parameters['count'] = $sentReminders->getTotalItemCount();

        return $this->render('admin/sent_reminder/index.html.twig', [
            'parameters' => $parameters,
            'sent_reminders' => $sentReminders,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(SentReminder $sentReminder): Response
    {
        return $this->render('admin/sent_reminder/show.html.twig', [
            'sent_reminder' => $sentReminder,
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        SentReminder $sentReminder,
        SentReminderManager $sentReminderManager
    ): Response {
        $sentReminderManager->undelete($sentReminder);

        return $this->redirectToRoute(
            'admin_sent_reminder_show',
            [
                'uuid' => $sentReminder->getUuid(),
            ],
            Response::HTTP_SEE_OTHER
        );
    }
}
