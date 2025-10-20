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
        $admin->setRoles(['ROLE_ADMIN']); //donne les droits à l'Admin
        $admin->setNom('Admin');
        $admin->setPrenom('LineNails');
        $admin->setPassword(
            $this->passwordHasher->hashPassword( //mot de passe sécurisé grace à passwordhasher
                $admin,
                'password'
            )
        );
        $manager->persist($admin); //info à doctrine
        
        // === 2. Création des Catégories ===
        $categories = [];
        $categoriesData = ['Mains', 'Pieds', 'Cils'];
        foreach ($categoriesData as $i => $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            $categorie->setOrdreAffichage($i + 1); 
            $manager->persist($categorie);
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
        foreach ($servicesData as $serviceData) {
            $service = new Service();
            $service->setNom($serviceData['nom']);
            $service->setPrix($serviceData['prix']);
            $service->setDescription('Description pour ' . $serviceData['nom']);
            $service->setDureeMinutes($serviceData['duree']);
            $service->setEstActif(true);
            // Associer la catégorie
            if (isset($categories[$serviceData['categorie']])) {
                $service->setCategorie($categories[$serviceData['categorie']]);
            }
            $manager->persist($service);
            $services[] = $service; // Stocker les services créés
        }

        // Création de quelques réalisations pour le portfolio
         for ($i = 1; $i <= 6; $i++) {
            $portfolio = new Portfolio();
            $portfolio->setNom('Réalisation ' . $i);
            $portfolio->setDescription('Une description pour la réalisation ' . $i);

            // Associer un service au hasard
            if (!empty($services)) {
                $portfolio->setService($services[array_rand($services)]);
            }

            $manager->persist($portfolio);
        }

 
        // Création de la configuration du site 
        $config = new ConfigurationsSite();
        $config->setAdressePostale('123 Rue de la Beauté, 75001 Paris');
        $config->setTelephone('01 23 45 67 89');
        $config->setEmailContact('contact@linenails.com');
        $config->setHorairesOuverture('Lundi - Vendredi : 9h - 19h');
        $config->setUrlPageFacebook('https://facebook.com/linenails');
        $config->setUrlPageInstgram('https://instagram.com/linenails');
        $config->setUrlPriseRdvFacebook('https://facebook.com/linenails/book');
        $manager->persist($config);

        // À la fin, flush enverra tout en base de données.
        $manager->flush();
    }
}