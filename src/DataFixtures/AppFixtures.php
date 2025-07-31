<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
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
            'Pose complète', 'Remplissage', 'Réparation d\'ongle', 'Dépose', 'Nail Art simple', 'Soin des mains'
        ];
        foreach ($categoriesData as $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            $manager->persist($categorie);
        }
        
        // === 3. Création des Services ===
        $servicesData = [
            'Manucure Classique' => 25.00,
            'Pédicure Complète' => 35.00,
            'Pose de Vernis Semi-Permanent' => 30.00,
            'Extension d\'ongles en gel' => 60.00,
        ];

        $services = []; // Tableau pour stocker les objets Service
        foreach ($servicesData as $nom => $prix) {
            $service = new Service();
            $service->setNom($nom);
            $service->setPrix($prix);
            $manager->persist($service);
            $services[$nom] = $service; // On stocke l'objet pour le lier plus tard
        }

        // === 4. Création du Portfolio ===
        $portfolio1 = new Portfolio();
        $portfolio1->setNom('Jolie Pose d\'été');
        $portfolio1->setService($services['Pose de Vernis Semi-Permanent']); // Liaison directe
        $manager->persist($portfolio1);

        $portfolio2 = new Portfolio();
        $portfolio2->setNom('Effet marbré sur ongles longs');
        $portfolio2->setService($services['Extension d\'ongles en gel']); // Liaison directe
        $manager->persist($portfolio2);

        // === 5. Envoi à la base de données ===
        $manager->flush();
    }
}