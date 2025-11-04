<?php

namespace App\Repository;

use App\Entity\ConfigurationsSite;//Importe l'entité ConfigurationsSite
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;//Importe la classe de base ServiceEntityRepository fournie par Doctrine.
use Doctrine\Persistence\ManagerRegistry;//Importe le ManagerRegistry.service Doctrine qui gère les connexions à la BDD.


class ConfigurationsSiteRepository extends ServiceEntityRepository//déclaration de la classe
{
    public function __construct(ManagerRegistry $registry)//le constructeur de la classe
    {
        parent::__construct($registry, ConfigurationsSite::class);//le constructeur de la classe parente
    }

    
}
