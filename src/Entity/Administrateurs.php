<?php

namespace App\Entity;

use App\Repository\AdministrateursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministrateursRepository::class)]
class Administrateurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_utilisateur = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $mot_de_passe_hash = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nom_utilisateur;
    }

    public function setNomUtilisateur(string $nom_utilisateur): static
    {
        $this->nom_utilisateur = $nom_utilisateur;

        return $this;
    }

    public function getMotDePasseHash(): ?string
    {
        return $this->mot_de_passe_hash;
    }

    public function setMotDePasseHash(string $mot_de_passe_hash): static
    {
        $this->mot_de_passe_hash = $mot_de_passe_hash;

        return $this;
    }
}
