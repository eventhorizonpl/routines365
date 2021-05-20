<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\{Quote, User};
use App\Enum\UserRoleEnum;
use App\Factory\QuoteFactory;
use App\Form\Admin\QuoteType;
use App\Manager\QuoteManager;
use App\Repository\QuoteRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(UserRoleEnum::ROLE_ADMIN)]
#[Route('/admin/quote', name: 'admin_quote_')]
class QuoteController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        PaginatorInterface $paginator,
        QuoteRepository $quoteRepository,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $quotesQuery = $quoteRepository->findByParametersForAdmin($parameters);
        $quotes = $paginator->paginate(
            $quotesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $quotes->getTotalItemCount();

        return $this->render('admin/quote/index.html.twig', [
            'parameters' => $parameters,
            'quotes' => $quotes,
        ]);
    }

    #[Route('/new', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        QuoteFactory $quoteFactory,
        QuoteManager $quoteManager,
        Request $request
    ): Response {
        $quote = $quoteFactory->createQuote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $quoteManager->save($quote, (string) $this->getUser());

            return $this->redirectToRoute('admin_quote_show', [
                'uuid' => $quote->getUuid(),
            ]);
        }

        return $this->render('admin/quote/new.html.twig', [
            'form' => $form->createView(),
            'quote' => $quote,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Quote $quote): Response
    {
        return $this->render('admin/quote/show.html.twig', [
            'quote' => $quote,
        ]);
    }

    #[Route('/{uuid}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        Quote $quote,
        QuoteManager $quoteManager,
        Request $request
    ): Response {
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $quoteManager->save($quote, (string) $this->getUser());

            return $this->redirectToRoute('admin_quote_show', [
                'uuid' => $quote->getUuid(),
            ]);
        }

        return $this->render('admin/quote/edit.html.twig', [
            'form' => $form->createView(),
            'quote' => $quote,
        ]);
    }

    #[IsGranted(UserRoleEnum::ROLE_SUPER_ADMIN)]
    #[Route('/{uuid}', methods: ['DELETE'], name: 'delete')]
    public function delete(
        Quote $quote,
        QuoteManager $quoteManager,
        Request $request
    ): Response {
        if (true === $this->isCsrfTokenValid(
            sprintf(
                'delete%s',
                (string) $quote->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $quoteManager->softDelete($quote, (string) $this->getUser());
        }

        return $this->redirectToRoute('admin_quote_index');
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Quote $quote,
        QuoteManager $quoteManager
    ): Response {
        $quoteManager->undelete($quote);

        return $this->redirectToRoute('admin_quote_show', [
            'uuid' => $quote->getUuid(),
        ]);
    }
}
