<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Service;
use App\Form\ContactType;
use App\Entity\NbVisiteur;
use App\Entity\Subscriber;
use App\Form\SubscriberType;
use App\Service\NbVisiteurService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/{message_recu}", name="home")
     */
    public function index($message_recu = null, Request $request, NbVisiteurService $visiteurService)
    {

        $visiteurService->inc_visiteur();

        $manager = $this->getDoctrine()->getManager();
        
        $repo = $this->getDoctrine()->getRepository(Service::class);

        $services = $repo->findAll();

        $contact = new Contact();

        $contact_form = $this->createForm(ContactType::class, $contact);
        $contact_form->handleRequest($request);
        
        if($contact_form->isSubmitted() &&  $contact_form->isValid())
        {
            $contact->setCreatedAt(new \DateTime('now'));
            
            $manager->persist($contact);
            $manager->flush();

            return $this->redirectToRoute("home", ['message_recu'=>1548585]);
        }

        $subscriber = new Subscriber();

        $subscriber_form = $this->createForm(SubscriberType::class, $subscriber);
        $subscriber_form->handleRequest($request);
        
        if($subscriber_form->isSubmitted() &&  $subscriber_form->isValid())
        {
            
            $manager->persist($subscriber);
            $manager->flush();

            return $this->redirectToRoute("home", ['message_recu'=>882528]);
        }

        return $this->render('home/index.html.twig', [
            'services' => $services,
            'subscriber_form' => $subscriber_form->createView(),
            'contact_form' => $contact_form->createView(),
            'message_recu' => $message_recu == null? 0: $message_recu,
        ]);
    }
}
