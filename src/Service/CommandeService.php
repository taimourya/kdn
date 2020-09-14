<?php

namespace App\Service;

use App\Entity\Commande;
use App\Repository\CommandeRepository;

class CommandeService
{
    private $repo;

    public function __construct(CommandeRepository $repo) 
    {
            $this->repo = $repo;
    }
    public function get_total(Commande $commande)
    {
        $total = $commande->getTemplate()->getService()->getPrice();

        if($commande->getWithHost())
            $total += 1000;
        if($commande->getWithMaintenance())
            $total += 1000;
        if($commande->getWithNewsletter())
            $total += 500;
            
        return $total;
    }

    public function nb_valider()
    {
        return count($this->repo->findValider());
    }
    public function nb_attente()
    {
        return count($this->repo->findEnattente());
    }
    public function nb_annuler()
    {
        return count($this->repo->findAnnuler());
    }

    public function argent_gagner()
    {
        $s = 0;
        $commandes = $this->repo->findValider();
        foreach($commandes as $commande)
        {
            $s += $this->get_total($commande);
        }

        return $s;
    }
}