<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\UserLoginDto;
use App\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\{Model, Security};
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1', defaults: ['topdomain' => 'com'], host: 'api.routines365.{topdomain}', name: 'api_v1_security_', requirements: ['topdomain' => 'com|local'])]
class SecurityController extends AbstractFOSRestController
{
    /**
     * @OA\Response(
     *     response=200,
     *     description="Returns the browser notifications of an user",
     *     @Model(type=UserLoginDto::class, groups={"login"})
     * )
     * @OA\Tag(name="Security")
     */
    #[Route('/login', methods: ['POST'], name: 'login')]
    public function postLogin(Request $request)
    {
        $user = $this->getUser();

        $data = new UserLoginDto(Response::HTTP_OK, $user);
        $view = $this->view($data, Response::HTTP_OK);
        $view->getContext()->addGroup('login');

        return $this->handleView($view);
    }
}
