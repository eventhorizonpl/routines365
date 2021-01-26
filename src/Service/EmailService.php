<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
    private MailerInterface $mailer;

    public function __construct(
        MailerInterface $mailer
    ) {
        $this->mailer = $mailer;
    }

    public function prepare(
        string $email,
        string $subject,
        string $template,
        string $textTemplate = null,
        array $context = []
    ): TemplatedEmail {
        $templatedEmail = (new TemplatedEmail())
            ->from(new Address('noreply@routines365.com', 'Routines365'))
            ->to($email)
            ->subject($subject)
            ->htmlTemplate($template)
        ;

        if (null !== $textTemplate) {
            $templatedEmail->textTemplate($textTemplate);
        }

        if (!(empty($context))) {
            $templatedEmail->context($context);
        }

        return $templatedEmail;
    }

    public function send(
        TemplatedEmail $templatedEmail
    ): bool {
        try {
            $this->mailer->send($templatedEmail);

            return true;
        } catch (TransportExceptionInterface $e) {
            return false;
        }
    }

    public function sendCompletedRoutineCongratulations(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/completed_routine_congratulations.html.twig',
            'email/completed_routine_congratulations.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendConfirmation(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/confirmation.html.twig',
            'email/confirmation.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendContactRequest(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/contact_request.html.twig',
            'email/contact_request.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendInvitation(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/invitation.html.twig',
            'email/invitation.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendMotivational(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/motivational.html.twig',
            'email/motivational.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendNewLead(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/new_lead.html.twig',
            'email/new_lead.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendReminderMessage(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/reminder_message.html.twig',
            'email/reminder_message.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendRequestForTestimonial(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/request_for_testimonial.html.twig',
            'email/request_for_testimonial.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendResetPassword(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/reset_password.html.twig',
            'email/reset_password.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendUserKpi(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/user_kpi.html.twig',
            null,
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendUserKytBasicConfiguration(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/user_kyt/basic_configuration.html.twig',
            'email/user_kyt/basic_configuration.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendUserKytCompletingRoutines(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/user_kyt/completing_routines.html.twig',
            'email/user_kyt/completing_routines.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendUserKytGoals(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/user_kyt/goals.html.twig',
            'email/user_kyt/goals.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendUserKytNotes(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/user_kyt/notes.html.twig',
            'email/user_kyt/notes.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendUserKytProjects(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/user_kyt/projects.html.twig',
            'email/user_kyt/projects.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendUserKytReminders(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/user_kyt/reminders.html.twig',
            'email/user_kyt/reminders.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendUserKytRewards(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/user_kyt/rewards.html.twig',
            'email/user_kyt/rewards.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }

    public function sendUserKytRoutines(
        string $email,
        string $subject,
        array $context = []
    ): bool {
        $templatedEmail = $this->prepare(
            $email,
            $subject,
            'email/user_kyt/routines.html.twig',
            'email/user_kyt/routines.txt.twig',
            $context
        );

        $result = $this->send($templatedEmail);

        return $result;
    }
}
