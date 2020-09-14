<?php

namespace App\Service;

use App\Entity\Commande;
use App\Repository\ContactRepository;

class ContactService
{
    private $repo;

    public function __construct(ContactRepository $repo) 
    {
            $this->repo = $repo;
    }

    public function nb_contacts()
    {
        return count($this->repo->findAll());
    }
}