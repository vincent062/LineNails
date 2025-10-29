<?php

namespace App\Entity; //Namespace de l'entité

use App\Repository\PortfolioRepository;  //Importation de la classe PortfolioRepository
use Doctrine\DBAL\Types\Types; //Importation de la classe Types
use Doctrine\ORM\Mapping as ORM; //Importation des outils de Mapping de Doctrine

#[ORM\Entity(repositoryClass: PortfolioRepository::class)] //Annotation de l'entité
class Portfolio
{
    #[ORM\Id] //Annotation de l'attribut id
    #[ORM\GeneratedValue] //Annotation de l'ORM pour l'auto-incrémentation
    #[ORM\Column] //Annotation de l'ORM pour la colonne
    private ?int $id = null; // Attribut id de type null


    #[ORM\Column(length: 255)] // Annotation de l'ORM pour la colonne avec une longueur de 255
    private ?string $nom = null; // Attribut nom de type string qui peut être null

    #[ORM\ManyToOne(inversedBy: 'portfolios')] //Relation ManyToOne entre l'entité Portfolio et Service
    private ?Service $service = null; // 

    #[ORM\Column(type: Types::TEXT, nullable: true)] // Annotation de l'ORM pour la colonne de type TEXT qui peut être null
    private ?string $description = null; // Attribut descriptions de type string qui peut être null

    #[ORM\Column(length: 255, nullable: true)] // Annotation de l'ORM pour la colonne avec une longueur de 255
    private ?string $image = null; // Attribut images de type string qui peut être null

    public function getId(): ?int // Déclare une fonction publique getId
    {
        return $this->id; // Retourne l'attribut id
    }

    public function getNom(): ?string // Méthode getNom de type string
    {
        return $this->nom; // Retourne l'attribut nom
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
}