<?php

namespace App\Controller\Admin;

use App\Entity\Quote;
use App\Factory\QuoteFactory;
use App\Form\QuoteType;
use App\Manager\QuoteManager;
use App\Repository\QuoteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/quote", name="admin_")
 */
class QuoteController extends AbstractController
{
    /**
     * @Route("/", name="quote_index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        QuoteRepository $quoteRepository,
        Request $request
    ): Response {
        $options = [
            'query' => $request->query->get('q'),
        ];

        $queryResult = $quoteRepository->findByOptions($options);
        $quotes = $paginator->paginate(
            $queryResult,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render('admin/quote/index.html.twig', [
            'options' => $options,
            'quotes' => $quotes,
        ]);
    }

    /**
     * @Route("/new", name="quote_new", methods={"GET","POST"})
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
     * @Route("/{uuid}", name="quote_show", methods={"GET"})
     */
    public function show(Quote $quote): Response
    {
        return $this->render('admin/quote/show.html.twig', [
            'quote' => $quote,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="quote_edit", methods={"GET","POST"})
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
     * @IsGranted("ROLE_SUPER_ADMIN")
     * @Route("/{uuid}", name="quote_delete", methods={"DELETE"})
     */
    public function delete(
        Quote $quote,
        QuoteManager $quoteManager,
        Request $request
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$quote->getUuid(), $request->request->get('_token'))) {
            $quoteManager->softDelete($quote, $this->getUser());
        }

        return $this->redirectToRoute('admin_quote_index');
    }
}
