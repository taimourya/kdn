<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Service;
use App\Entity\Commande;
use App\Entity\Template;
use App\Form\ServiceType;
use App\Entity\Newsletter;
use App\Entity\Subscriber;
use App\Form\TemplateType;
use App\Form\NewsletterType;
use App\Service\FileUploader;
use App\Service\ContactService;
use App\Service\CommandeService;
use App\Service\NbVisiteurService;
use App\Service\NewsletterService;
use App\Service\SubscriberService;
use App\Form\TemplateSansServiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin", name="admin")
     */
    public function index(NbVisiteurService $visiteurService, CommandeService $commandeService, SubscriberService $subscriberService, ContactService $contactService)
    {
        return $this->render('admin/index.html.twig', [
            'nombre_visiteur' => $visiteurService->get_nombreVisiteur(),
            'nombre_commande_valider' => $commandeService->nb_valider(),
            'nombre_commande_attente' => $commandeService->nb_attente(),
            'nombre_commande_annuler' => $commandeService->nb_annuler(),
            'nombre_subscriber' => $subscriberService->nb_subscriber(),
            'nombre_contact' => $contactService->nb_contacts(),
            'argent_gagner' => $commandeService->argent_gagner(),
        ]);
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////                          SERVICE                            //////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/services", name="admin_services")
     */
    public function services()
    {
        $repo = $this->getDoctrine()->getRepository(Service::class);

        $services = $repo->findAll();

        return $this->render('admin/service/services.html.twig', [
            'services' => $services,
        ]);
    }
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/service/ajouter", name="admin_addService")
     */
    public function addService(Request $request)
    {
        
        $service = new Service();

        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($service);
            $manager->flush();
            
            return $this->redirectToRoute("admin_services");
        }

        return $this->render('admin/service/addService.html.twig', [
            'form' => $form->createView(),
            'editMode' => 0,
        ]);
    }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/service/edit/{service}", name="admin_editService")
     */
    public function editService(Service $service, Request $request)
    {
        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($service);
            $manager->flush();
            
            return $this->redirectToRoute("admin_services");
        }

        return $this->render('admin/service/addService.html.twig', [
            'form' => $form->createView(),
            'editMode' => 1,
        ]);
    }
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/service/{service}/add/template", name="admin_serviceaddtemplate")
     */
    public function addtemplateToService(Service $service, Request $request, FileUploader $fileUploader)
    {
        $template = new Template();

        $template->setService($service);

        $form = $this->createForm(TemplateSansServiceType::class, $template);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $template->setImage($imageFileName);
            }

            $manager->persist($template);
            $manager->flush();
            
            return $this->redirectToRoute("admin_services");
        }

        return $this->render('admin/service/addtemplateToService.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/service/remove/{service}", name="admin_removeService")
     */
    public function removeService(Service $service)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($service);
        $manager->flush();

        return $this->redirectToRoute("admin_services");
    }


    

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////                          Template                           //////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/templates", name="admin_templates")
     */
    public function templates()
    {
        $repo = $this->getDoctrine()->getRepository(Template::class);

        $templates = $repo->findAll();

        return $this->render('admin/template/templates.html.twig', [
            'templates' => $templates,
        ]);
    }
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/template/ajouter", name="admin_addTemplate")
     */
    public function addTemplate(Request $request, FileUploader $fileUploader)
    {
        $template = new Template();

        $form = $this->createForm(TemplateType::class, $template);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();


            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $template->setImage($imageFileName);
            }

            
            $manager->persist($template);
            $manager->flush();
            
            return $this->redirectToRoute("admin_templates");
        }

        return $this->render('admin/template/addTemplate.html.twig', [
            'form' => $form->createView(),
            'editMode' => 0,
        ]);
    }
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/template/edit/{template}", name="admin_editTemplate")
     */
    public function editTemplate(Template $template, Request $request)
    {
        $form = $this->createForm(TemplateType::class, $template);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($template);
            $manager->flush();
            
            return $this->redirectToRoute("admin_templates");
        }

        return $this->render('admin/template/addTemplate.html.twig', [
            'form' => $form->createView(),
            'editMode' => 1,
        ]);
    }

    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/template/remove/{template}", name="admin_removeTemplate")
     */
    public function removeTemplate(Template $template)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($template);
        $manager->flush();

        return $this->redirectToRoute("admin_templates");
    }


    

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////                          Commande                           //////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/commandes", name="admin_commandes")
     */
    public function commandes()
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);

        $commandes = $repo->findAll();

        return $this->render('admin/commande/commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/commande/show/{commande}", name="admin_show_commande")
     */
    public function show_commande(commande $commande, CommandeService $commandeService)
    {
        return $this->render('admin/commande/show.html.twig', [
            'commande' => $commande,
            'total' => $commandeService->get_total($commande)
        ]);
    }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/commande/annulerCommande_nonTerminer", name="admin_annulerCommande_nonTerminer")
     */
    public function annulerCommande_nonTerminer()
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $manager = $this->getDoctrine()->getManager();

        $commandes = $repo->findNonTerminer();

        foreach($commandes as $commande)
        {
            $commande->setStat('annuler');
            $manager->persist($commande);
        }

        $manager->flush();
       
        return $this->redirectToRoute("admin_commandes");
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/commande/valider/{commande}", name="admin_validerCommande")
     */
    public function validerCommande(Commande $commande)
    {

        if($commande->getStat() === 'en attente')
        {
            $manager = $this->getDoctrine()->getManager();
            $commande->setStat('valider');
            $manager->flush();
        }
       
        return $this->redirectToRoute("admin_commandes");
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/commande/annuler/{commande}", name="admin_annulerCommande")
     */
    public function annulerCommande(Commande $commande)
    {

        if($commande->getStat() !== 'annuler')
        {
            $manager = $this->getDoctrine()->getManager();
            $commande->setStat('annuler');
            $manager->flush();
        }
       
        return $this->redirectToRoute("admin_commandes");
    }


    

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////                          Contact                           //////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/contacts", name="admin_contacts")
     */
    public function contacts()
    {
        $repo = $this->getDoctrine()->getRepository(Contact::class);

        $contacts = $repo->findAll();

        return $this->render('admin/contact/contacts.html.twig', [
            'contacts' => $contacts,
        ]);
    }    

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/contact/show/{contact}", name="admin_show_contact")
     */
    public function show_contact(Contact $contact)
    {
        return $this->render('admin/contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////                          Subscriber                        //////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/subscribers", name="admin_subscribers")
     */
     public function subscribers()
     {
         $repo = $this->getDoctrine()->getRepository(Subscriber::class);
 
         $subscribers = $repo->findAll();
 
         return $this->render('admin/subscriber/subscribers.html.twig', [
             'subscribers' => $subscribers,
         ]);
     }   

     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/subscriber/remove/{subscriber}", name="admin_removeSubscriber")
     */
    public function removeSubscriber(Subscriber $subscriber)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($subscriber);
        $manager->flush();

        return $this->redirectToRoute("admin_subscribers");
    }





    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////                          Newsletter                        //////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/newsletters", name="admin_newsletters")
     */
     public function newsletters()
     {
         $repo = $this->getDoctrine()->getRepository(Newsletter::class);
 
         $newsletters = $repo->findAll();
 
         return $this->render('admin/newsletter/newsletters.html.twig', [
             'newsletters' => $newsletters,
         ]);
     } 

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/newsletter/ajouter", name="admin_addNewsletter")
     */
    public function addNewsletter(Request $request)
    {
        
        $newsletter = new Newsletter();

        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($newsletter);
            $manager->flush();
            
            return $this->redirectToRoute("admin_newsletters");
        }

        return $this->render('admin/newsletter/addNewsletter.html.twig', [
            'form' => $form->createView(),
            'editMode' => 0,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/newsletter/edit/{newsletter}", name="admin_editNewsletter")
     */
     public function editNewsletter(Request $request, Newsletter $newsletter)
     {
         $form = $this->createForm(NewsletterType::class, $newsletter);
 
         $form->handleRequest($request);
 
         if($form->isSubmitted() &&  $form->isValid())
         {
             $manager = $this->getDoctrine()->getManager();
             
             $manager->persist($newsletter);
             $manager->flush();
             
             return $this->redirectToRoute("admin_newsletters");
         }
 
         return $this->render('admin/newsletter/addNewsletter.html.twig', [
             'form' => $form->createView(),
             'editMode' => 1,
         ]);
     }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/newsletter/send/{newsletter}", name="admin_newsletter_send")
     */
    public function newsletter_send(Newsletter $newsletter, NewsletterService $newsService)
    {
        $newsService->send_newsletter($newsletter);
        return $this->redirectToRoute("admin_commandes");
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/newsletter/remove/{newsletter}", name="admin_removeNewsletter")
     */
     public function removeNewsletter(Newsletter $newsletter)
     {
         $manager = $this->getDoctrine()->getManager();
 
         $manager->remove($newsletter);
         $manager->flush();
 
         return $this->redirectToRoute("admin_newsletters");
     }
}
