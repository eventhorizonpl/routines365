<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Retention;
use App\Entity\User;
use App\Manager\RetentionManager;
use App\Repository\RetentionRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(User::ROLE_ADMIN)]
#[Route('/admin/retention', name: 'admin_retention_')]
class RetentionController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        PaginatorInterface $paginator,
        Request $request,
        RetentionRepository $retentionRepository
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $retentionsQuery = $retentionRepository->findByParametersForAdmin($parameters);
        $retentions = $paginator->paginate(
            $retentionsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $retentions->getTotalItemCount();

        return $this->render('admin/retention/index.html.twig', [
            'parameters' => $parameters,
            'retentions' => $retentions,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Retention $retention): Response
    {
        return $this->render('admin/retention/show.html.twig', [
            'retention' => $retention,
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Retention $retention,
        RetentionManager $retentionManager
    ): Response {
        $retentionManager->undelete($retention);

        return $this->redirectToRoute('admin_retention_show', [
            'uuid' => $retention->getUuid(),
        ]);
    }
}
