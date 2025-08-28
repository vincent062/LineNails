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
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setNom('Admin');
        $admin->setPrenom('LineNails');
        $admin->setPassword(
            $this->passwordHasher->hashPassword(
                $admin,
                'password'
            )
        );
        $manager->persist($admin);
        
        // === 2. Création des Catégories ===
        $categoriesData = ['Mains','Pieds','Cils'];
        foreach ($categoriesData as $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            $categorie->setOrdreAffichage(1); 
            $manager->persist($categorie);
        }
        
        // === 3. Création des Services ===
        $servicesData = [
            'Manucure Classique' => ['prix' => 18.00, 'duree' => 45],
            'Pédicure Complète' => ['prix' => 30.00, 'duree' => 60],
            'Semi-Permanent' => ['prix' => 25.00, 'duree' => 30],
            'Renfort Semi-Permanent' => ['prix' => 33.00, 'duree' => 30],
            'Capsule Américaine' => ['prix' => 35.00, 'duree' => 30],
            'Popits' => ['prix' => 45.00, 'duree' => 90],
            'Nail Art (par ongle)' => ['prix' => 3.00, 'duree' => 15],
            'French/Baby Boomer (par main)' => ['prix' => 5.00, 'duree' => 20],
            'Depose' => ['prix' => 15.00, 'duree' => 20],
            'Depose autre institut' => ['prix' => 18.00, 'duree' => 30],
            'Reparation Ongle' => ['prix' => 3.00, 'duree' => 10],
            'Press on Nails (sur commande)' => ['prix' => 0, 'duree' => 0],
        ];

        foreach ($servicesData as $nom => $details) {
            $service = new Service();
            $service->setNom($nom);
            $service->setPrix($details['prix']);
            $service->setDescription('Description pour ' . $nom);
            $service->setDureeMinutes($details['duree']);
            $service->setEstActif(true);
            $manager->persist($service);
            $this->addReference($nom, $service);
        }

        // === 4. Création du Portfolio ===
       // Boucle pour créer 6 paires de Service + Portfolio
         for ($i = 1; $i <= 6; $i++) {
    // === 1. Créer le Service ===
          $service = new Service();
          $service->setNom('Renfort / Semi-Permanent' . $i);
          
          $service = new Service();
          $service->setNom('Capsule Américaine' . $i);

          $service = new Service();
          $service->setNom('Popits' . $i);

          $service = new Service();
          $service->setNom('Nail Art' . $i);

          $service = new Service();
          $service->setNom('French / Baby Boomer' . $i);

          $service = new Service();
          $service->setNom('Press on Nails' . $i);
    
    
          $manager->persist($service); // On prépare la sauvegarde du nouveau service

    // === 2. Créer le Portfolio ===
          $portfolio = new Portfolio();
          $portfolio->setNom('Réalisation ' . $i);
    
    // === 3. Lier directement les deux objets ===
    // Pas besoin de getReference, on a la variable $service sous la main !
         $portfolio->setService($service);
    
         $manager->persist($portfolio); // On prépare la sauvegarde du nouveau portfolio
}

// À la fin, un seul flush() enverra tout en base de données.
// $manager->flush();
 
        // === 5. Création de la configuration du site ===
        $config = new ConfigurationsSite();
        $config->setAdressePostale('123 Rue de la Beauté, 75001 Paris');
        $config->setTelephone('01 23 45 67 89');
        $config->setEmailContact('contact@linenails.com');
        $config->setHorairesOuverture('Lundi - Vendredi : 9h - 19h');
        $config->setUrlPageFacebook('https://facebook.com/linenails');
        $config->setUrlPageInstgram('https://instagram.com/linenails');
        $config->setUrlPriseRdvFacebook('https://facebook.com/linenails/book');
        $manager->persist($config);
        
        $manager->flush();
    }
}