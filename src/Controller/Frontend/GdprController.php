<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/settings/gdpr", name="frontend_gdpr_")
 */
class GdprController extends AbstractController
{
    /**
     * @Route("/", name="show", methods={"GET"})
     */
    public function show(): Response
    {
        return $this->render('frontend/gdpr/show.html.twig');
    }

    /**
     * @Route("/export", name="export", methods={"GET"})
     */
    public function export(SerializerInterface $serializer): Response
    {
        $user = $this->getUser();
        $xml = $serializer->serialize($user, 'xml', ['groups' => 'gdpr']);
        $file = tempnam('/tmp', 'gdpr');
        file_put_contents($file, $xml);

        return $this->file($file, 'gdpr.xml');
    }
}
