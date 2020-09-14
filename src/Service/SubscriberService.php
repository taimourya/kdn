<?php

namespace App\Service;

use App\Entity\Commande;
use App\Repository\SubscriberRepository;

class SubscriberService
{
    private $repo;

    public function __construct(SubscriberRepository $repo) 
    {
            $this->repo = $repo;
    }

    public function nb_subscriber()
    {
        return count($this->repo->findAll());
    }
}