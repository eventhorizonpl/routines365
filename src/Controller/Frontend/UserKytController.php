<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Enum\UserRoleEnum;
use App\Resource\KytResource;
use App\Service\UserKytService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(UserRoleEnum::ROLE_USER)]
#[Route('/know-your-tools', name: 'frontend_user_kyt_')]
class UserKytController extends AbstractController
{
    #[Route('/basic-configuration', methods: ['GET'], name: 'basic_configuration')]
    public function basicConfiguration(): Response
    {
        return $this->render('frontend/user_kyt/basic_configuration.html.twig', [
            'know_your_tools' => KytResource::BASIC_CONFIGURATION_START,
        ]);
    }

    #[Route('/basic-configuration-finish', methods: ['GET'], name: 'basic_configuration_finish')]
    public function basicConfigurationFinish(
        TranslatorInterface $translator,
        UserKytService $userKytService
    ): Response {
        $userKyt = $this->getUser()->getUserKyt();

        if ((null !== $userKyt) && (false === $userKyt->getBasicConfigurationLearned())) {
            $userKyt->setBasicConfigurationLearned(true);
            $used = $userKytService->rewardUserKyt($userKyt);

            if (true === $used) {
                $this->addFlash(
                    'success',
                    $translator->trans('We added a small reward to your account.')
                );
            }
        }

        return $this->redirectToRoute('frontend_user_kyt_start');
    }

    #[Route('/completing-routines', methods: ['GET'], name: 'completing_routines')]
    public function completingRoutines(): Response
    {
        return $this->render('frontend/user_kyt/completing_routines.html.twig', [
            'know_your_tools' => KytResource::COMPLETING_ROUTINES_START,
        ]);
    }

    #[Route('/completing-routines-finish', methods: ['GET'], name: 'completing_routines_finish')]
    public function completingRoutinesFinish(
        TranslatorInterface $translator,
        UserKytService $userKytService
    ): Response {
        $userKyt = $this->getUser()->getUserKyt();

        if ((null !== $userKyt) && (false === $userKyt->getCompletingRoutinesLearned())) {
            $userKyt->setCompletingRoutinesLearned(true);
            $used = $userKytService->rewardUserKyt($userKyt);

            if (true === $used) {
                $this->addFlash(
                    'success',
                    $translator->trans('We added a small reward to your account.')
                );
            }
        }

        return $this->redirectToRoute('frontend_user_kyt_start');
    }

    #[Route('/goals', methods: ['GET'], name: 'goals')]
    public function goals(): Response
    {
        return $this->render('frontend/user_kyt/goals.html.twig', [
            'know_your_tools' => KytResource::GOALS_START,
        ]);
    }

    #[Route('/goals-finish', methods: ['GET'], name: 'goals_finish')]
    public function goalsFinish(
        TranslatorInterface $translator,
        UserKytService $userKytService
    ): Response {
        $userKyt = $this->getUser()->getUserKyt();

        if ((null !== $userKyt) && (false === $userKyt->getGoalsLearned())) {
            $userKyt->setGoalsLearned(true);
            $used = $userKytService->rewardUserKyt($userKyt);

            if (true === $used) {
                $this->addFlash(
                    'success',
                    $translator->trans('We added a small reward to your account.')
                );
            }
        }

        return $this->redirectToRoute('frontend_user_kyt_start');
    }

    #[Route('/notes', methods: ['GET'], name: 'notes')]
    public function notes(): Response
    {
        return $this->render('frontend/user_kyt/notes.html.twig', [
            'know_your_tools' => KytResource::NOTES_START,
        ]);
    }

    #[Route('/notes-finish', methods: ['GET'], name: 'notes_finish')]
    public function notesFinish(
        TranslatorInterface $translator,
        UserKytService $userKytService
    ): Response {
        $userKyt = $this->getUser()->getUserKyt();

        if ((null !== $userKyt) && (false === $userKyt->getNotesLearned())) {
            $userKyt->setNotesLearned(true);
            $used = $userKytService->rewardUserKyt($userKyt);

            if (true === $used) {
                $this->addFlash(
                    'success',
                    $translator->trans('We added a small reward to your account.')
                );
            }
        }

        return $this->redirectToRoute('frontend_user_kyt_start');
    }

    #[Route('/projects', methods: ['GET'], name: 'projects')]
    public function projects(): Response
    {
        return $this->render('frontend/user_kyt/projects.html.twig', [
            'know_your_tools' => KytResource::PROJECTS_START,
        ]);
    }

    #[Route('/projects-finish', methods: ['GET'], name: 'projects_finish')]
    public function projectsFinish(
        TranslatorInterface $translator,
        UserKytService $userKytService
    ): Response {
        $userKyt = $this->getUser()->getUserKyt();

        if ((null !== $userKyt) && (false === $userKyt->getProjectsLearned())) {
            $userKyt->setProjectsLearned(true);
            $used = $userKytService->rewardUserKyt($userKyt);

            if (true === $used) {
                $this->addFlash(
                    'success',
                    $translator->trans('We added a small reward to your account.')
                );
            }
        }

        return $this->redirectToRoute('frontend_user_kyt_start');
    }

    #[Route('/reminders', methods: ['GET'], name: 'reminders')]
    public function reminders(): Response
    {
        return $this->render('frontend/user_kyt/reminders.html.twig', [
            'know_your_tools' => KytResource::REMINDERS_START,
        ]);
    }

    #[Route('/reminders-finish', methods: ['GET'], name: 'reminders_finish')]
    public function remindersFinish(
        TranslatorInterface $translator,
        UserKytService $userKytService
    ): Response {
        $userKyt = $this->getUser()->getUserKyt();

        if ((null !== $userKyt) && (false === $userKyt->getRemindersLearned())) {
            $userKyt->setRemindersLearned(true);
            $used = $userKytService->rewardUserKyt($userKyt);

            if (true === $used) {
                $this->addFlash(
                    'success',
                    $translator->trans('We added a small reward to your account.')
                );
            }
        }

        return $this->redirectToRoute('frontend_user_kyt_start');
    }

    #[Route('/rewards', methods: ['GET'], name: 'rewards')]
    public function rewards(): Response
    {
        return $this->render('frontend/user_kyt/rewards.html.twig', [
            'know_your_tools' => KytResource::REWARDS_START,
        ]);
    }

    #[Route('/rewards-finish', methods: ['GET'], name: 'rewards_finish')]
    public function rewardsFinish(
        TranslatorInterface $translator,
        UserKytService $userKytService
    ): Response {
        $userKyt = $this->getUser()->getUserKyt();

        if ((null !== $userKyt) && (false === $userKyt->getRewardsLearned())) {
            $userKyt->setRewardsLearned(true);
            $used = $userKytService->rewardUserKyt($userKyt);

            if (true === $used) {
                $this->addFlash(
                    'success',
                    $translator->trans('We added a small reward to your account.')
                );
            }
        }

        return $this->redirectToRoute('frontend_user_kyt_start');
    }

    #[Route('/routines', methods: ['GET'], name: 'routines')]
    public function routines(): Response
    {
        return $this->render('frontend/user_kyt/routines.html.twig', [
            'know_your_tools' => KytResource::ROUTINES_START,
        ]);
    }

    #[Route('/routines-finish', methods: ['GET'], name: 'routines_finish')]
    public function routinesFinish(
        TranslatorInterface $translator,
        UserKytService $userKytService
    ): Response {
        $userKyt = $this->getUser()->getUserKyt();

        if ((null !== $userKyt) && (false === $userKyt->getRoutinesLearned())) {
            $userKyt->setRoutinesLearned(true);
            $used = $userKytService->rewardUserKyt($userKyt);

            if (true === $used) {
                $this->addFlash(
                    'success',
                    $translator->trans('We added a small reward to your account.')
                );
            }
        }

        return $this->redirectToRoute('frontend_user_kyt_start');
    }

    #[Route('/start', methods: ['GET'], name: 'start')]
    public function start(): Response
    {
        $userKyt = $this->getUser()->getUserKyt();

        return $this->render('frontend/user_kyt/start.html.twig', [
            'user_kyt' => $userKyt,
        ]);
    }
}
