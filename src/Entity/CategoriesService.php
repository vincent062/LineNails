<?php

namespace App\Entity;

use App\Repository\CategoriesServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesServiceRepository::class)]
class CategoriesService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_categorie_service = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $ordre_affichage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCategorieService(): ?int
    {
        return $this->id_categorie_service;
    }

    public function setIdCategorieService(int $id_categorie_service): static
    {
        $this->id_categorie_service = $id_categorie_service;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getOrdreAffichage(): ?int
    {
        return $this->ordre_affichage;
    }

    public function setOrdreAffichage(int $ordre_affichage): static
    {
        $this->ordre_affichage = $ordre_affichage;

        return $this;
    }
}
