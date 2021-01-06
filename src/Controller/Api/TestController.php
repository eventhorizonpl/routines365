<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\TestDto;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1", name="api_v1_")
 */
class TestController extends AbstractFOSRestController
{
    /**
     * @Route("/test", name="test", methods={"GET"})
     */
    public function getTest()
    {
        $data = new TestDto(Response::HTTP_OK, ['test' => 'ok']);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}
