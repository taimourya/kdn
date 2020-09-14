<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact/{message_recu}", name="contact")
     */
    public function index($message_recu = null, Request $request)
    {
        
        $contact = new Contact();

        $contact_form = $this->createForm(ContactType::class, $contact);
        $contact_form->handleRequest($request);
        
        if($contact_form->isSubmitted() &&  $contact_form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();

            $contact->setCreatedAt(new \DateTime('now'));
            
            $manager->persist($contact);
            $manager->flush();

            return $this->redirectToRoute("contact", ['message_recu'=>1]);
        }

        return $this->render('contact/index.html.twig', [
            'contact_form' => $contact_form->createView(),
            'message_recu' => $message_recu != null,
        ]);
    }
}
