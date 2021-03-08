<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Reminder;
use App\Entity\Routine;
use App\Entity\User;
use App\Factory\ReminderFactory;
use App\Form\Frontend\ReminderType;
use App\Manager\ReminderManager;
use App\Resource\KytResource;
use App\Security\Voter\ReminderVoter;
use App\Security\Voter\RoutineVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(User::ROLE_USER)]
#[Route('/reminders', name: 'frontend_reminder_')]
class ReminderController extends AbstractController
{
    #[Route('/{uuid}/new', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        ReminderFactory $reminderFactory,
        ReminderManager $reminderManager,
        Request $request,
        Routine $routine,
        TranslatorInterface $translator
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        if (null === $this->getUser()->getProfile()->getTimeZone()) {
            $this->addFlash(
                'danger',
                $translator->trans('Please set up time zone!')
            );

            return $this->redirectToRoute('frontend_profile_edit');
        }

        $reminder = $reminderFactory->createReminder();
        $reminder->setRoutine($routine);
        $reminder->setUser($this->getUser());
        $form = $this->createForm(ReminderType::class, $reminder);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $reminderManager->save($reminder, (string) $this->getUser());

            if ($knowYourTools) {
                return $this->redirectToRoute('frontend_routine_show_reminders', [
                    'know_your_tools' => KytResource::REMINDERS_SHOW3,
                    'uuid' => $routine->getUuid(),
                ]);
            } else {
                return $this->redirectToRoute('frontend_routine_show_reminders', [
                    'uuid' => $routine->getUuid(),
                ]);
            }
        }

        return $this->render('frontend/reminder/new.html.twig', [
            'form' => $form->createView(),
            'know_your_tools' => $knowYourTools,
            'reminder' => $reminder,
            'routine' => $routine,
        ]);
    }

    #[Route('/{uuid}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        Reminder $reminder,
        ReminderManager $reminderManager,
        Request $request,
        TranslatorInterface $translator
    ): Response {
        $this->denyAccessUnlessGranted(ReminderVoter::EDIT, $reminder);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        if (null === $this->getUser()->getProfile()->getTimeZone()) {
            $this->addFlash(
                'danger',
                $translator->trans('Please set up time zone!')
            );

            return $this->redirectToRoute('frontend_profile_edit');
        }

        $form = $this->createForm(ReminderType::class, $reminder);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $reminderManager->save($reminder, (string) $this->getUser());

            if ($knowYourTools) {
                return $this->redirectToRoute('frontend_routine_show_reminders', [
                    'know_your_tools' => KytResource::REMINDERS_FINISH,
                    'uuid' => $reminder->getRoutine()->getUuid(),
                ]);
            } else {
                return $this->redirectToRoute('frontend_routine_show_reminders', [
                    'uuid' => $reminder->getRoutine()->getUuid(),
                ]);
            }
        }

        return $this->render('frontend/reminder/edit.html.twig', [
            'form' => $form->createView(),
            'know_your_tools' => $knowYourTools,
            'reminder' => $reminder,
            'routine' => $reminder->getRoutine(),
        ]);
    }

    #[Route('/{uuid}', methods: ['DELETE'], name: 'delete')]
    public function delete(
        Reminder $reminder,
        ReminderManager $reminderManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(ReminderVoter::DELETE, $reminder);

        if (true === $this->isCsrfTokenValid(
            sprintf(
                'delete%s',
                (string) $reminder->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $reminderManager->softDelete($reminder, (string) $this->getUser());
        }

        return $this->redirectToRoute('frontend_routine_show_reminders', [
            'uuid' => $reminder->getRoutine()->getUuid(),
        ]);
    }
}
