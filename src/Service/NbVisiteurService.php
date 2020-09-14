<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\NbVisiteur;
use App\Repository\NbVisiteurRepository;
use Doctrine\ORM\EntityManagerInterface;

class NbVisiteurService
{ 
    private $repo;
    private $manager;

    public function __construct(NbVisiteurRepository $repo, EntityManagerInterface $manager) 
    {
            $this->repo = $repo;
            $this->manager = $manager;
    }

    public function get_nombreVisiteur()
    {
        $nbVisiteur = $this->repo->findAll();
        
        return count($nbVisiteur) == 0? 1 : $nbVisiteur[0]->getNombre();
    }
    public function inc_visiteur()
    {
        $nbVisiteur = $this->repo->findAll();

        if(count($nbVisiteur) == 0)
        {
            $visiteur = new NbVisiteur();
            $visiteur->setNombre(1);

            $this->manager->persist($visiteur);
        }
        else
        {
            $nbVisiteur[0]->setNombre($nbVisiteur[0]->getNombre() + 1);
            
            $this->manager->persist($nbVisiteur[0]);
        }

        $this->manager->flush();

    }
}