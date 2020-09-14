<?php

namespace App\Service;

use App\Entity\Newsletter;
use App\Repository\SubscriberRepository;


class NewsletterService
{
    private $subs_repo;
    private $mailer;
    public function __construct(SubscriberRepository $subs_repo, \Swift_Mailer $mailer) 
    {
            $this->subs_repo = $subs_repo;
            $this->mailer = $mailer;
    }

    public function send_newsletter(Newsletter $newsletter)
    {
        $subscribers = $this->subs_repo->findAll();

        foreach($subscribers as $subscriber)
        {
            $message = (new \Swift_Message($newsletter->getSubject()))
                ->setFrom('taimouriya@gmail.com')
                ->setTo($subscriber->getEmail())  
                ->setBody($newsletter->getMessage())
            ;

            $this->mailer->send($message);
        }
    }
}