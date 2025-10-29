<?php
// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\ConfigurationsSite;
use App\Entity\Portfolio;
use App\Entity\Service;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // === 1. Création de l'utilisateur Admin ===
        $admin = new User(); //création de l'objet USER
        $admin->setEmail('admin@example.com'); //informations
<<<<<<< HEAD
        $admin->setRoles(['ROLE_ADMIN']); // donne les droits à l'admin
        $admin->setNom('Admin');
        $admin->setPrenom('LineNails');
        $admin->setPassword(
            $this->passwordHasher->hashPassword( //mot de passe sécurisé grace à passwordHasher
=======
        $admin->setRoles(['ROLE_ADMIN']); //donne les droits à l'Admin
        $admin->setNom('Admin');
        $admin->setPrenom('LineNails');
        $admin->setPassword(
            $this->passwordHasher->hashPassword( //mot de passe sécurisé grace à passwordhasher
>>>>>>> 23e85ed827b2afa1b5747efa6b727114dfe43db1
                $admin,
                'password'
            )
        );
<<<<<<< HEAD
        $manager->persist($admin); // info à doctrine 
=======
        $manager->persist($admin); //info à doctrine
>>>>>>> 23e85ed827b2afa1b5747efa6b727114dfe43db1
        
        // === 2. Création des Catégories ===
        $categories = [];
        $categoriesData = ['Mains', 'Pieds', 'Cils']; //creation d'un tableau pour les catégories
        foreach ($categoriesData as $i => $nom) { // boucle permettant de parcourir chaque éléments du tableau
            $categorie = new Categorie(); //création d'un nouvel objet "categorie"
            $categorie->setNom($nom); //donne un nom à mon objet
            $categorie->setOrdreAffichage($i + 1);  //définis l'ordre d'affichage avec l'index de la boucle
            $manager->persist($categorie); //info à doctrine
            $categories[$nom] = $categorie; // Stocker pour une utilisation ultérieure
        }
        
        // === 3. Création des Services ===
        $servicesData = [
            // Mains
            ['nom' =>'Manucure Simple', 'prix' => 18.00, 'duree' => 45, 'categorie' => 'Mains'],
            ['nom'=>'Semi-Permanent','prix' => 25.00, 'duree' => 30, 'categorie' => 'Mains'],
            ['nom'=>'Renfort Semi-Permanent','prix' => 33.00, 'duree' => 30, 'categorie' => 'Mains'],
            ['nom'=>'Capsule Américaine','prix' => 35.00, 'duree' => 30, 'categorie' => 'Mains'],
            ['nom'=>'Popits','prix' => 45.00, 'duree' => 90, 'categorie' => 'Mains'],
            ['nom'=>'Nail Art (par ongle)','prix' => 3.00, 'duree' => 15, 'categorie' => 'Mains'],
            ['nom'=>'French/Baby Boomer (par main)','prix' => 5.00, 'duree' => 20, 'categorie' => 'Mains'],
            ['nom'=>'Depose','prix' => 15.00, 'duree' => 20, 'categorie' => 'Mains'],
            ['nom'=>'Depose autre institut','prix' => 18.00, 'duree' => 30, 'categorie' => 'Mains'],
            ['nom'=>'Reparation Ongle','prix' => 3.00, 'duree' => 10, 'categorie' => 'Mains'],
            ['nom'=>'Press on Nails (sur commande)','prix' => 0, 'duree' => 0, 'categorie' => 'Mains'],
            // Pieds
            ['nom' =>'Pédicure Simple' , 'prix' =>20.00, 'duree' =>45, 'categorie' => 'Pieds'],
            ['nom' =>'Pédicure / Semi-Permanent' , 'prix' => 30.00, 'duree' => 60, 'categorie' => 'Pieds'],
            // Cils (Exemple)
            ['nom' =>'Rehaussement de cils' , 'prix' => 40.00, 'duree' => 60, 'categorie' => 'Cils'],

        ];

        $services = [];
        foreach ($servicesData as $serviceData) {  //boucle permettant de parcourir chaque éléments du tableau
            $service = new Service();  //création d'un nouvel objet
            $service->setNom($serviceData['nom']);
            $service->setPrix($serviceData['prix']);
            $service->setDescription('Description pour ' . $serviceData['nom']);
            $service->setDureeMinutes($serviceData['duree']);
            $service->setEstActif(true);
            // Associer la catégorie
            if (isset($categories[$serviceData['categorie']])) { //on verifie si la categorie existe bien
                $service->setCategorie($categories[$serviceData['categorie']]);  //si la categorie existe on la recupere
            }
            $manager->persist($service); //info à doctrine
            $services[] = $service; //Stocker les services créés
        }

        // Création de quelques réalisations pour le portfolio
         for ($i = 1; $i <= 6; $i++) {  //boucle for qui va s'executer 6 fois
            $portfolio = new Portfolio();  //création d'un nouvel objet
            $portfolio->setNom('Réalisation ' . $i);
            $portfolio->setDescription('Une description pour la réalisation ' . $i);

            // Associer un service au hasard
            if (!empty($services)) {  //verifie que le tableau services n'est pas vide
                $portfolio->setService($services[array_rand($services)]);  //prendre un service au hasard et l'associer au portfolio
            }

            $manager->persist($portfolio);  //info à doctrine
        }

 
        // Création de la configuration du site 
        $config = new ConfigurationsSite();  //création d'un nouvel objet
        $config->setAdressePostale('123 Rue de la Beauté, 75001 Paris');  //informations
        $config->setTelephone('01 23 45 67 89');
        $config->setEmailContact('contact@linenails.com');
        $config->setHorairesOuverture('Lundi - Vendredi : 9h - 19h');
        $config->setUrlPageFacebook('https://facebook.com/linenails');
        $config->setUrlPageInstgram('https://instagram.com/linenails');
        $config->setUrlPriseRdvFacebook('https://facebook.com/linenails/book');
        $manager->persist($config);  //info à doctrine

        // À la fin, flush enverra tout en base de données.
        $manager->flush();
    }
}