<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Portfolio;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // === 1. Création des Catégories ===
        $categoriesData = [
            'Pose complète',
            'Remplissage',
            'Réparation d\'ongle',
            'Dépose',
            'Nail Art simple',
            'Soin des mains'
        ];

        foreach ($categoriesData as $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            $manager->persist($categorie);
        }
        
        // === 2. Création des Services ===
        $servicesData = [
            'Manucure Classique' => 25.00,
            'Pédicure Complète' => 35.00,
            'Pose de Vernis Semi-Permanent' => 30.00,
            'Extension d\'ongles en gel' => 60.00,
        ];

        $services = []; // On va stocker les objets Service ici
        foreach ($servicesData as $nom => $prix) {
            $service = new Service();
            $service->setNom($nom);
            $service->setPrix($prix);
            $manager->persist($service);
            // On stocke l'objet service dans un tableau pour l'utiliser juste après
            $services[$nom] = $service;
        }

        // === 3. Création du Portfolio (en utilisant les services créés ci-dessus) ===
        $portfolio1 = new Portfolio();
        $portfolio1->setNom('Jolie Pose d\'été');
        $portfolio1->setService($services['Pose de Vernis Semi-Permanent']); // On utilise directement l'objet
        $manager->persist($portfolio1);

        $portfolio2 = new Portfolio();
        $portfolio2->setNom('Effet marbré sur ongles longs');
        $portfolio2->setService($services['Extension d\'ongles en gel']); // On utilise directement l'objet
        $manager->persist($portfolio2);

        // === 4. On envoie tout à la base de données en une seule fois ===
        $manager->flush();
    }
}