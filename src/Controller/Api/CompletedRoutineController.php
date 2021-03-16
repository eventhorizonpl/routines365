<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\CompletedRoutineListDto;
use App\Dto\CompletedRoutineShowDto;
use App\Dto\ErrorResponseDto;
use App\Entity\Routine;
use App\Entity\User;
use App\Factory\CompletedRoutineFactory;
use App\Form\Api\CompletedRoutineType;
use App\Manager\CompletedRoutineManager;
use App\Repository\CompletedRoutineRepository;
use App\Repository\RoutineRepository;
use App\Security\Voter\RoutineVoter;
use DateTimeImmutable;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Knp\Component\Pager\PaginatorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(User::ROLE_USER)]
#[Route('/api/v1/completed-routines', defaults: ['topdomain' => 'com'], host: 'api.routines365.{topdomain}', name: 'api_v1_completed_routine_', requirements: ['topdomain' => 'com|local'])]
class CompletedRoutineController extends AbstractFOSRestController
{
    /**
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="The field used to limit",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="The field used to paginate",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns the completed routines of a routine",
     *     @Model(type=CompletedRoutineListDto::class, groups={"list"})
     * )
     * @OA\Tag(name="CompletedRoutines")
     */
    #[Route('/{uuid}', methods: ['GET'], name: 'list')]
    #[Security(name: 'api_key')]
    public function getList(
        CompletedRoutineRepository $completedRoutineRepository,
        PaginatorInterface $paginator,
        Request $request,
        Routine $routine
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);

        $completedRoutinesQuery = $completedRoutineRepository->findByParametersForApi($this->getUser(), $routine);
        $completedRoutines = $paginator->paginate(
            $completedRoutinesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        $completedRoutines = $completedRoutines->getItems();

        $data = new CompletedRoutineListDto(Response::HTTP_OK, $completedRoutines);
        $view = $this->view($data, Response::HTTP_OK);
        $view->getContext()->addGroup('list');

        return $this->handleView($view);
    }

    /**
     * @OA\Post(
     *     @OA\RequestBody(
     *         required=true,
     *         @Model(type=CompletedRoutineType::class)
     *     )
     * )
     * @OA\Response(
     *     response=201,
     *     description="Creates the completed routines",
     *     @Model(type=CompletedRoutineShowDto::class, groups={"show"})
     * )
     * @OA\Tag(name="CompletedRoutines")
     */
    #[Route('/', methods: ['POST'], name: 'new')]
    #[Security(name: 'api_key')]
    public function post(
        CompletedRoutineFactory $completedRoutineFactory,
        CompletedRoutineManager $completedRoutineManager,
        Request $request,
        RoutineRepository $routineRepository
    ): Response {
        $routine = $routineRepository->findOneByUuid($request->request->get('routineUuid'));
        $date = new DateTimeImmutable($request->request->get('completedDate'));
        $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);
        $completedRoutine = $completedRoutineFactory->createCompletedRoutine();
        $completedRoutine->setDate($date);
        $completedRoutine->setRoutine($routine);
        $completedRoutine->setUser($this->getUser());
        $form = $this->createForm(CompletedRoutineType::class, $completedRoutine);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $completedRoutineManager->save($completedRoutine, (string) $this->getUser());

            $data = new CompletedRoutineShowDto(Response::HTTP_CREATED, $completedRoutine);
            $view = $this->view($data, Response::HTTP_CREATED);
            $view->getContext()->addGroup('show');

            return $this->handleView($view);
        }

        $data = new ErrorResponseDto(Response::HTTP_BAD_REQUEST);
        $view = $this->view($data, Response::HTTP_BAD_REQUEST);
        $view->getContext()->addGroup('show');

        return $this->handleView($view);
    }
}
