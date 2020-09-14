<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Template;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TemplateController extends AbstractController
{
    /**
     * @Route("/template/catalogue/{service}", name="template_catalogue")
     */
    public function index(Service $service)
    {
        return $this->render('template/index.html.twig', [
            'templates' => $service->getTemplates(),
        ]);
    }

    /**
     * @Route("/template/show/{template}", name="template_show")
     */
    public function show_template(Template $template)
    {
        
        return $this->render('template/show.html.twig', [
            'template' => $template,
        ]);
    }
}
