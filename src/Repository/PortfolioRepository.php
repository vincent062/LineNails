<?php

namespace App\Repository; //Défini le namespace de la classe

use App\Entity\Portfolio; // Entité Doctrine
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository; // Classe de base de Symfony
use Doctrine\Persistence\ManagerRegistry; // Permet d'accéder aux entités de Doctrine


class PortfolioRepository extends ServiceEntityRepository // Déclare la classe qui hérite de ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) 
    {
        parent::__construct($registry, Portfolio::class);
    }

    
}
