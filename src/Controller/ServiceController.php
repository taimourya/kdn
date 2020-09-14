<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\CommandeStep3Type;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    /**
     * @Route("/services/liste", name="services")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Service::class);

        $services = $repo->findAll();

        return $this->render('service/index.html.twig', [
            'services' => $services,
        ]);
    }
}
