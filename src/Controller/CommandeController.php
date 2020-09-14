<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Template;
use App\Form\CommandeStep1Type;
use App\Form\CommandeStep2Type;
use App\Form\CommandeStep3Type;
use App\Service\CommandeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{

    /**
     * @Route("/commande/test", name="commande_test")
     */
    public function index()
    {
        return $this->render('commande/index.html.twig', [
        ]);
    }
    /**
     * @Route("/commande/creation/etape1/{template}", name="commande_creation1")
     */
    public function etape1(Template $template, Request $request)
    {
        $commande = new Commande();
        $commande->setTemplate($template)
                    ->setDescription("")
                    ->setWithMaintenance(false)
                    ->setWithHost(false)
                    ->setWithNewsletter(false)
                    ->setCreatedAt(new \DateTime('now'))
                    ->setStat('en cours de creation')
        ;

        $form = $this->createForm(CommandeStep1Type::class, $commande);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($commande);
            $manager->flush();
            
            return $this->redirectToRoute("commande_creation2", ['commande'=>$commande->getId()]);
        }

        return $this->render('commande/creation.html.twig', [
            'form' => $form->createView(),
            'etape' => 1,
            'title_form' => 'Information Personnel',
        ]);
    }

     /**
     * @Route("/commande/creation/etape1edit/{commande}", name="commande_creation1edit")
     */
    public function etape1Edit(Commande $commande, Request $request)
    {
        $commande->setCreatedAt(new \DateTime('now'))
                 ->setStat('en cours de modification')
        ;
        $form = $this->createForm(CommandeStep1Type::class, $commande);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($commande);
            $manager->flush();
            
            return $this->redirectToRoute("commande_creation2", ['commande'=>$commande->getId()]);
        }

        return $this->render('commande/creation.html.twig', [
            'form' => $form->createView(),
            'etape' => 1,
            'title_form' => 'Information Personnel',
        ]);
    }

    /**
     * @Route("/commande/creation/etape2/{commande}", name="commande_creation2")
     */
    public function etape2(Commande $commande, Request $request)
    {
        $form = $this->createForm(CommandeStep2Type::class, $commande);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($commande);
            $manager->flush();
            
            return $this->redirectToRoute("commande_creation3", ['commande'=>$commande->getId()]);
        }

        return $this->render('commande/creation.html.twig', [
            'form' => $form->createView(),
            'etape' => 2,
            'title_form' => 'Description de la commande',
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/commande/creation/etape3/{commande}", name="commande_creation3")
     */
    public function etape3(Commande $commande, Request $request, \Swift_Mailer $mailer, CommandeService $commandeService)
    {
        $form = $this->createForm(CommandeStep3Type::class, $commande);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            
            $commande->setStat('en attente');
            $manager->persist($commande);
            $manager->flush();
            
            $message = (new \Swift_Message('Commande sur le site kendevart effectué avec succes'))
                ->setFrom('test@gmail.com')
                ->setTo('fkinroxi@gmail.com')  
                ->setBody(
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'commande/email_message.html.twig', [
                            'commande' => $commande,
                            'total' => $commandeService->get_total($commande)
                        ]),
                    'text/html'
                )
            ;

            $mailer->send($message);
            
            return $this->redirectToRoute("commande_show", ['commande'=>$commande->getId()]);
        }

        return $this->render('commande/creation.html.twig', [
            'form' => $form->createView(),
            'etape' => 3,
            'title_form' => 'Ajouter des options',
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/commande/creation/show/{commande}", name="commande_show")
     */
    public function show(Commande $commande, Request $request, CommandeService $commandeService)
    {
        
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
            'total' => $commandeService->get_total($commande)
        ]);
    }

    /**
     * @Route("/commande/annuler/{commande}", name="commande_annuler")
     */
    public function annuler(Commande $commande, Request $request)
    {
        
        $manager = $this->getDoctrine()->getManager();

        $commande->setStat('annuler');
        $manager->persist($commande);
        $manager->flush();

        return $this->redirectToRoute("template_show", ['template'=> $commande->getTemplate()->getId()]);
    }
}
