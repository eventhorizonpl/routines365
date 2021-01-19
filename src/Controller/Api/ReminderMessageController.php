<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\ReminderMessageListDto;
use App\Entity\Reminder;
use App\Entity\ReminderMessage;
use App\Entity\User;
use App\Repository\ReminderMessageRepository;
use DateTime;
use DateTimeImmutable;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/api/v1/reminder-message", name="api_v1_reminder_message_", host="api.routines365.{topdomain}", defaults={"topdomain"="com"}, requirements={"topdomain"="com|local"})
 */
class ReminderMessageController extends AbstractFOSRestController
{
    /**
     * @Route("/browser-notifications-list", name="browser_notifications_list", methods={"GET"}, options={"expose"=true})
     */
    public function getBrowserNotificationsList(ReminderMessageRepository $reminderMessageRepository)
    {
        $reminders = $this->getUser()->getReminders()->filter(function (Reminder $reminder) {
            return true === $reminder->getSendToBrowser();
        });

        $dateTime = new DateTime();
        $dateTime->modify('-1 hour');
        $postDate = DateTimeImmutable::createFromMutable($dateTime);

        $reminderMessages = $reminderMessageRepository->findByRemindersAndPostDateAndType($reminders, $postDate, ReminderMessage::TYPE_BROWSER);

        $data = new ReminderMessageListDto(Response::HTTP_OK, $reminderMessages);
        $view = $this->view($data, Response::HTTP_OK);
        $view->getContext()->addGroup('list');

        return $this->handleView($view);
    }
}
