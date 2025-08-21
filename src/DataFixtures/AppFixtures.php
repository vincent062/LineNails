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
            'Mains','Pieds','Cils'
        ];
        foreach ($categoriesData as $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            $manager->persist($categorie);
        }
        
        // === 3. Création des Services ===
        $servicesData = [
            'Manucure Classique' => [18.00,'durée'=>0],
            'Pédicure Complète' => [30.00,'durée'=>0],
            'Pose de Vernis Semi-Permanent' => [25.00,'durée'=>0],
            'Extension d\'ongles en gel' => [45.00,'durée'=>0],
            'Deco/Nail Art' => [3.00,'durée'=>0],
            'French/Baby Boomer'=>[5.00,'durée'=>0],
            'Depose'=> [15.00,'durée'=>0],
            'Depose autre institut'=> [18.00,'durée'=>0],
            'Reparation Ongle'=> [3.00,'durée'=>0],
            'Press on Nails',
        ];

        $services = []; // Tableau pour stocker les objets Service
        foreach ($servicesData as $nom => $details) {
            $service = new Service();
            $service->setNom($nom);
            $service->setPrix($details['prix']);
            $service->setDescription('Une description pour le service ' . $nom);
            $service->setDureeMinutes($details['durée']);
            $service->setEstActif(true);
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

        $portfolio3 = new Portfolio();
        $portfolio3->setNom('Jolie Pose d\'été');
        $portfolio3->setService($services['Pose de Vernis Semi-Permanent']); // Liaison directe
        $manager->persist($portfolio3);

        $portfolio4 = new Portfolio();
        $portfolio4->setNom('Jolie Pose d\'été');
        $portfolio4->setService($services['Pose de Vernis Semi-Permanent']); // Liaison directe
        $manager->persist($portfolio4);

        $portfolio5 = new Portfolio();
        $portfolio5->setNom('Jolie Pose d\'été');
        $portfolio5->setService($services['Pose de Vernis Semi-Permanent']); // Liaison directe
        $manager->persist($portfolio5);
 
        // === 5. Envoi à la base de données ===
        $manager->flush();

        $config = new ConfigurationsSite();
        $config->setTitre('LineNails - Prothésiste Ongulaire');
        $config->setAdressePostale('123 Rue de la Beauté, 75001 Paris');
        $config->setNumeroTelephone('01 23 45 67 89');
        $config->setEmail('contact@linenails.com');
        $config->setOrdreAffichage(1); // On donne une valeur au champ obligatoire !
        
        $manager->persist($config);
        
        // On envoie tout à la base de données
        $manager->flush();
    }

}