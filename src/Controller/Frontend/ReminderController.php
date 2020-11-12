<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Reminder;
use App\Entity\Routine;
use App\Entity\User;
use App\Factory\ReminderFactory;
use App\Form\Frontend\ReminderType;
use App\Manager\ReminderManager;
use App\Security\Voter\ReminderVoter;
use App\Security\Voter\RoutineVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/reminders", name="frontend_reminder_")
 */
class ReminderController extends AbstractController
{
    /**
     * @Route("/{uuid}/new", name="new", methods={"GET","POST"})
     */
    public function new(
        ReminderFactory $reminderFactory,
        ReminderManager $reminderManager,
        Request $request,
        Routine $routine,
        TranslatorInterface $translator
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);

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
            $reminderManager->save($reminder, $this->getUser());

            return $this->redirectToRoute('frontend_routine_show_reminders', [
                'uuid' => $routine->getUuid(),
            ]);
        }

        return $this->render('frontend/reminder/new.html.twig', [
            'form' => $form->createView(),
            'reminder' => $reminder,
            'routine' => $routine,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Reminder $reminder,
        ReminderManager $reminderManager,
        Request $request,
        TranslatorInterface $translator
    ): Response {
        $this->denyAccessUnlessGranted(ReminderVoter::EDIT, $reminder);

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
            $reminderManager->save($reminder, $this->getUser());

            return $this->redirectToRoute('frontend_routine_show_reminders', [
                'uuid' => $reminder->getRoutine()->getUuid(),
            ]);
        }

        return $this->render('frontend/reminder/edit.html.twig', [
            'form' => $form->createView(),
            'reminder' => $reminder,
            'routine' => $reminder->getRoutine(),
        ]);
    }

    /**
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Reminder $reminder,
        ReminderManager $reminderManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(ReminderVoter::DELETE, $reminder);

        if (true === $this->isCsrfTokenValid(
            'delete'.$reminder->getUuid(),
            $request->request->get('_token')
        )) {
            $reminderManager->softDelete($reminder, $this->getUser());
        }

        return $this->redirectToRoute('frontend_routine_show_reminders', [
            'uuid' => $reminder->getRoutine()->getUuid(),
        ]);
    }
}
