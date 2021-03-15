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
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(User::ROLE_USER)]
#[Route('/api/v1/reminder-messages', defaults: ['topdomain' => 'com'], host: 'api.routines365.{topdomain}', name: 'api_v1_reminder_message_', requirements: ['topdomain' => 'com|local'])]
class ReminderMessageController extends AbstractFOSRestController
{
    /**
     * @OA\Response(
     *     response=200,
     *     description="Returns the browser notifications of an user",
     *     @Model(type=ReminderMessageListDto::class, groups={"list"})
     * )
     * @OA\Tag(name="ReminderMessages")
     */
    #[Route('/browser-notifications-list', methods: ['GET'], name: 'browser_notifications_list', options: ['expose' => true])]
    #[Security(name: 'api_key')]
    public function getBrowserNotificationsList(ReminderMessageRepository $reminderMessageRepository)
    {
        $reminders = $this->getUser()->getReminders()->filter(fn (Reminder $reminder) => true === $reminder->getSendToBrowser());

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
