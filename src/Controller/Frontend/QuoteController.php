<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\{Quote, SavedEmail, User};
use App\Enum\{SavedEmailTypeEnum, UserRoleEnum};
use App\Form\Frontend\SendMotivationalEmailType;
use App\Manager\QuoteManager;
use App\Repository\QuoteRepository;
use App\Resource\ConfigResource;
use App\Security\Voter\QuoteVoter;
use App\Service\{EmailService, SavedEmailService};
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(UserRoleEnum::ROLE_USER)]
#[Route('/motivate-friend', name: 'frontend_quote_')]
class QuoteController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        QuoteRepository $quoteRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        if (true !== ConfigResource::MOTIVATE_A_FRIEND_ENABLED) {
            return $this->redirectToRoute('frontend_home', [], Response::HTTP_SEE_OTHER);
        }

        $parameters = [
            'query' => trim((string) $request->query->get('q')),
        ];

        $quotesQuery = $quoteRepository->findByParametersForFrontend($parameters);
        $quotes = $paginator->paginate(
            $quotesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render('frontend/quote/index.html.twig', [
            'quotes' => $quotes,
            'parameters' => $parameters,
        ]);
    }

    #[Route('/{uuid}/send', methods: ['GET', 'POST'], name: 'send')]
    public function send(
        EmailService $emailService,
        Quote $quote,
        QuoteManager $quoteManager,
        Request $request,
        SavedEmailService $savedEmailService,
        TranslatorInterface $translator
    ): Response {
        if (true !== ConfigResource::MOTIVATE_A_FRIEND_ENABLED) {
            return $this->redirectToRoute('frontend_home', [], Response::HTTP_SEE_OTHER);
        }

        $this->denyAccessUnlessGranted(QuoteVoter::SEND, $quote);

        $user = $this->getUser();
        $profile = $user->getProfile();
        $firstName = $profile->getFirstName();
        $lastName = $profile->getLastName();

        if ((null === $firstName) || ('' === trim($firstName)) || (null === $lastName) || ('' === trim($lastName))) {
            $this->addFlash(
                'danger',
                $translator->trans('Please provide your first and last name!')
            );

            return $this->redirectToRoute('frontend_profile_edit', [], Response::HTTP_SEE_OTHER);
        }

        $subject = sprintf(
            'R365: %s %s %s',
            $firstName,
            $lastName,
            $translator->trans('sends you a motivational message')
        );

        $form = $this->createForm(SendMotivationalEmailType::class);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $sendMotivationalEmailType = $form->getData();
            $emailService->sendMotivational(
                $sendMotivationalEmailType->email,
                $subject,
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'quote' => $quote,
                ]
            );

            $quoteManager->incrementPopularity($quote);

            $savedEmailService->create(
                $sendMotivationalEmailType->email,
                SavedEmailTypeEnum::MOTIVATIONAL,
                $user
            );

            $this->addFlash(
                'success',
                $translator->trans('Email was sent. You can send motivational message to another person.')
            );

            return $this->redirectToRoute(
                'frontend_quote_send',
                [
                    'uuid' => $quote->getUuid(),
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('frontend/quote/send.html.twig', [
            'first_name' => $firstName,
            'form' => $form,
            'last_name' => $lastName,
            'quote' => $quote,
            'subject' => $subject,
        ]);
    }
}
