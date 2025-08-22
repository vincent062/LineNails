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
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // === 1. Création de l'utilisateur Admin ===
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword(
                $admin,
                'password' // Votre mot de passe sécurisé
            )
        );
        $manager->persist($admin);
        
        // === 2. Création des Catégories ===
        $categoriesData = [
            'Mains','Pieds','Cils'
        ];
        foreach ($categoriesData as $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            // On ajoute une valeur par défaut pour ordre_affichage
            $categorie->setOrdreAffichage(1); 
            $manager->persist($categorie);
        }
        
        // === 3. Création des Services ===
        $servicesData = [
            'Manucure Classique' => ['prix' => 18.00, 'duree' => 45],
            'Pédicure Complète' => ['prix' => 30.00, 'duree' => 60],
            'Pose de Vernis Semi-Permanent' => ['prix' => 25.00, 'duree' => 30],
            'Extension d\'ongles en gel' => ['prix' => 45.00, 'duree' => 90],
            'Deco/Nail Art' => ['prix' => 3.00, 'duree' => 15],
            'French/Baby Boomer' => ['prix' => 5.00, 'duree' => 20],
            'Depose' => ['prix' => 15.00, 'duree' => 20],
            'Depose autre institut' => ['prix' => 18.00, 'duree' => 30],
            'Reparation Ongle' => ['prix' => 3.00, 'duree' => 10],
            'Press on Nails' => ['prix' => 35.00, 'duree' => 0],
        ];

        $services = []; // Tableau pour stocker les objets Service
        foreach ($servicesData as $nom => $details) {
            $service = new Service();
            $service->setNom($nom);
            $service->setPrix($details['prix']);
            $service->setDescription('Une description pour le service ' . $nom);
            $service->setDureeMinutes($details['duree']);
            $service->setEstActif(true);
            $manager->persist($service);
            $services[$nom] = $service; // On stocke l'objet pour le lier plus tard
        }

        // === 4. Création du Portfolio ===
        for ($i = 1; $i <= 6; $i++) {
            $portfolio = new Portfolio();
            $portfolio->setNom('Réalisation ' . $i);
            // On alterne les services pour l'exemple
            $serviceKey = ($i % 2 == 0) ? 'Pose de Vernis Semi-Permanent' : 'Extension d\'ongles en gel';
            $portfolio->setService($services[$serviceKey]);
            $manager->persist($portfolio);
        }
 
        // === 5. Création de la configuration du site (CORRIGÉ) ===
        $config = new ConfigurationsSite();
        $config->setAdressePostale('123 Rue de la Beauté, 75001 Paris');
        $config->setTelephone('01 23 45 67 89');
        $config->setEmailContact('contact@linenails.com');
        $config->setHorairesOuverture('Lundi - Vendredi : 9h - 19h');
        $config->setUrlPageFacebook('https://facebook.com/linenails');
        $config->setUrlPageInstgram('https://instagram.com/linenails');
        $config->setUrlPriseRdvFacebook('https://facebook.com/linenails/book');
        $manager->persist($config);
        
        // On envoie tout à la base de données
        $manager->flush();
    }
}