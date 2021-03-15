<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\ErrorResponseDto;
use App\Dto\RoutineListDto;
use App\Dto\RoutineShowDto;
use App\Entity\Routine;
use App\Entity\User;
use App\Factory\RoutineFactory;
use App\Form\Api\RoutineType;
use App\Manager\RoutineManager;
use App\Repository\RoutineRepository;
use App\Security\Voter\RoutineVoter;
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
#[Route('/api/v1/routines', defaults: ['topdomain' => 'com'], host: 'api.routines365.{topdomain}', name: 'api_v1_reminder_message_', requirements: ['topdomain' => 'com|local'])]
class RoutineController extends AbstractFOSRestController
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
     * @OA\Parameter(
     *     name="query",
     *     in="query",
     *     description="The field used to filter by query",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="type",
     *     in="query",
     *     description="The field used to filter by type",
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns the routines of an user",
     *     @Model(type=RoutineListDto::class, groups={"list"})
     * )
     * @OA\Tag(name="Routines")
     */
    #[Route('/', methods: ['GET'], name: 'list')]
    #[Security(name: 'api_key')]
    public function getList(
        PaginatorInterface $paginator,
        Request $request,
        RoutineRepository $routineRepository
    ): Response {
        $parameters = [
            'query' => trim((string) $request->query->get('q')),
            'type' => $request->query->get('type'),
        ];

        $routinesQuery = $routineRepository->findByParametersForApi($this->getUser(), $parameters);
        $routines = $paginator->paginate(
            $routinesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        $routines = $routines->getItems();

        $data = new RoutineListDto(Response::HTTP_OK, $routines);
        $view = $this->view($data, Response::HTTP_OK);
        $view->getContext()->addGroup('list');

        return $this->handleView($view);
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Returns the routine",
     *     @Model(type=RoutineShowDto::class, groups={"show"})
     * )
     * @OA\Tag(name="Routines")
     */
    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    #[Security(name: 'api_key')]
    public function getShow(
        Routine $routine
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::VIEW, $routine);

        $data = new RoutineShowDto(Response::HTTP_OK, $routine);
        $view = $this->view($data, Response::HTTP_OK);
        $view->getContext()->addGroup('show');

        return $this->handleView($view);
    }

    /**
     * @OA\Post(
     *     @OA\RequestBody(
     *         required=true,
     *         @Model(type=RoutineType::class)
     *     )
     * )
     * @OA\Response(
     *     response=201,
     *     description="Creates the routine",
     *     @Model(type=RoutineShowDto::class, groups={"show"})
     * )
     * @OA\Tag(name="Routines")
     */
    #[Route('/', methods: ['POST'], name: 'new')]
    #[Security(name: 'api_key')]
    public function post(
        Request $request,
        RoutineFactory $routineFactory,
        RoutineManager $routineManager
    ): Response {
        $routine = $routineFactory->createRoutine();
        $routine->setUser($this->getUser());
        $form = $this->createForm(RoutineType::class, $routine);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $routineManager->save($routine, (string) $this->getUser());

            $data = new RoutineShowDto(Response::HTTP_CREATED, $routine);
            $view = $this->view($data, Response::HTTP_CREATED);
            $view->getContext()->addGroup('show');

            return $this->handleView($view);
        }

        $data = new ErrorResponseDto(Response::HTTP_BAD_REQUEST, 'Error');
        $view = $this->view($data, Response::HTTP_BAD_REQUEST);
        $view->getContext()->addGroup('show');

        return $this->handleView($view);
    }

    /**
     * @OA\Post(
     *     @OA\RequestBody(
     *         required=true,
     *         @Model(type=RoutineType::class)
     *     )
     * )
     * @OA\Response(
     *     response=200,
     *     description="Edits the routine",
     *     @Model(type=RoutineShowDto::class, groups={"show"})
     * )
     * @OA\Tag(name="Routines")
     */
    #[Route('/{uuid}', methods: ['PUT'], name: 'edit')]
    #[Security(name: 'api_key')]
    public function put(
        Routine $routine,
        Request $request,
        RoutineFactory $routineFactory,
        RoutineManager $routineManager
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);

        $form = $this->createForm(RoutineType::class, $routine, [
            'method' => 'PUT',
        ]);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $routineManager->save($routine, (string) $this->getUser());

            $data = new RoutineShowDto(Response::HTTP_OK, $routine);
            $view = $this->view($data, Response::HTTP_OK);
            $view->getContext()->addGroup('show');

            return $this->handleView($view);
        }

        $data = new ErrorResponseDto(Response::HTTP_BAD_REQUEST, 'Error');
        $view = $this->view($data, Response::HTTP_BAD_REQUEST);
        $view->getContext()->addGroup('show');

        return $this->handleView($view);
    }

    /**
     * @OA\Response(
     *     response=204,
     *     description="Deletes the routine"
     * )
     * @OA\Tag(name="Routines")
     */
    #[Route('/{uuid}', methods: ['DELETE'], name: 'delete')]
    #[Security(name: 'api_key')]
    public function delete(
        Routine $routine,
        Request $request,
        RoutineFactory $routineFactory,
        RoutineManager $routineManager
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::DELETE, $routine);

        $routineManager->softDelete($routine, (string) $this->getUser());

        $view = $this->view([], Response::HTTP_NO_CONTENT);

        return $this->handleView($view);
    }
}
