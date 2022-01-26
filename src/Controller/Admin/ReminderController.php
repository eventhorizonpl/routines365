<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\{Reminder, User};
use App\Enum\UserRoleEnum;
use App\Manager\ReminderManager;
use App\Repository\ReminderRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(UserRoleEnum::ROLE_ADMIN->value)]
#[Route('/admin/reminder', name: 'admin_reminder_')]
class ReminderController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        PaginatorInterface $paginator,
        ReminderRepository $reminderRepository,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $remindersQuery = $reminderRepository->findByParametersForAdmin($parameters);
        $reminders = $paginator->paginate(
            $remindersQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $reminders->getTotalItemCount();

        return $this->render('admin/reminder/index.html.twig', [
            'parameters' => $parameters,
            'reminders' => $reminders,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Reminder $reminder): Response
    {
        return $this->render('admin/reminder/show.html.twig', [
            'reminder' => $reminder,
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Reminder $reminder,
        ReminderManager $reminderManager
    ): Response {
        $reminderManager->undelete($reminder);

        return $this->redirectToRoute(
            'admin_reminder_show',
            [
                'uuid' => $reminder->getUuid(),
            ],
            Response::HTTP_SEE_OTHER
        );
    }

    #[Route('/{uuid}/unlock', methods: ['GET'], name: 'unlock')]
    public function unlock(
        Reminder $reminder,
        ReminderManager $reminderManager
    ): Response {
        $reminderManager->unlock($reminder);

        return $this->redirectToRoute(
            'admin_reminder_show',
            [
                'uuid' => $reminder->getUuid(),
            ],
            Response::HTTP_SEE_OTHER
        );
    }
}
