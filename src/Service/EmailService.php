<?php

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
        string $textTemplate,
        array $context = []
    ): TemplatedEmail {
        $templatedEmail = (new TemplatedEmail())
            ->from(new Address('noreply@routines365.com', 'Routines365'))
            ->to($email)
            ->subject($subject)
            ->htmlTemplate($template)
            ->textTemplate($textTemplate)
        ;

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
}
