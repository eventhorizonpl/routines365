<?php

namespace App\Controller\Admin;

use App\Entity\Quote;
use App\Entity\User;
use App\Factory\QuoteFactory;
use App\Form\Admin\QuoteType;
use App\Manager\QuoteManager;
use App\Repository\QuoteRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/quote", name="admin_quote_")
 */
class QuoteController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        QuoteRepository $quoteRepository,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim($request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $quotesQuery = $quoteRepository->findByParametersForAdmin($parameters);
        $quotes = $paginator->paginate(
            $quotesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/quote/index.html.twig', [
            'parameters' => $parameters,
            'quotes' => $quotes,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(
        QuoteFactory $quoteFactory,
        QuoteManager $quoteManager,
        Request $request
    ): Response {
        $quote = $quoteFactory->createQuote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $quoteManager->save($quote, $this->getUser());

            return $this->redirectToRoute('admin_quote_show', [
                'uuid' => $quote->getUuid(),
            ]);
        }

        return $this->render('admin/quote/new.html.twig', [
            'form' => $form->createView(),
            'quote' => $quote,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Quote $quote): Response
    {
        return $this->render('admin/quote/show.html.twig', [
            'quote' => $quote,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Quote $quote,
        QuoteManager $quoteManager,
        Request $request
    ): Response {
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $quoteManager->save($quote, $this->getUser());

            return $this->redirectToRoute('admin_quote_show', [
                'uuid' => $quote->getUuid(),
            ]);
        }

        return $this->render('admin/quote/edit.html.twig', [
            'form' => $form->createView(),
            'quote' => $quote,
        ]);
    }

    /**
     * @IsGranted(User::ROLE_SUPER_ADMIN)
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Quote $quote,
        QuoteManager $quoteManager,
        Request $request
    ): Response {
        if (true === $this->isCsrfTokenValid(
            'delete'.$quote->getUuid(),
            $request->request->get('_token')
        )) {
            $quoteManager->softDelete($quote, $this->getUser());
        }

        return $this->redirectToRoute('admin_quote_index');
    }

    /**
     * @Route("/{uuid}/undelete", name="undelete", methods={"GET"})
     */
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
