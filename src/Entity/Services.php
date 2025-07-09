<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
class Services
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_service = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?int $duree_minutes = null;

    #[ORM\Column]
    private ?bool $est_actif = null;

    #[ORM\Column]
    private ?int $id_categorie_service_fk = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdService(): ?int
    {
        return $this->id_service;
    }

    public function setIdService(int $id_service): static
    {
        $this->id_service = $id_service;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDureeMinutes(): ?int
    {
        return $this->duree_minutes;
    }

    public function setDureeMinutes(int $duree_minutes): static
    {
        $this->duree_minutes = $duree_minutes;

        return $this;
    }

    public function isEstActif(): ?bool
    {
        return $this->est_actif;
    }

    public function setEstActif(bool $est_actif): static
    {
        $this->est_actif = $est_actif;

        return $this;
    }

    public function getIdCategorieServiceFk(): ?int
    {
        return $this->id_categorie_service_fk;
    }

    public function setIdCategorieServiceFk(int $id_categorie_service_fk): static
    {
        $this->id_categorie_service_fk = $id_categorie_service_fk;

        return $this;
    }
}
