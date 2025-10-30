<?php
// src/Entity/User.php

namespace App\Entity;//Namespace de l'entité

use App\Repository\UserRepository;//Importation de la classe UserRepository
use Doctrine\ORM\Mapping as ORM;//Outils doctrine pour mapper la classe vers la BDD
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;//On s'assure que la valeur est unique
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;//
use Symfony\Component\Security\Core\User\UserInterface;//interface
use Symfony\Component\Validator\Constraints as Assert;//Outils de validation

#[ORM\Entity(repositoryClass: UserRepository::class)]//Annotation de l'entité
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cet email.')]//Régle de validation
class User implements UserInterface, PasswordAuthenticatedUserInterface//Défini la classe USER
{
    #[ORM\Id]//Annotation de l'attribut id
    #[ORM\GeneratedValue]//Annotation de l'ORM pour l'auto-incrémentation
    #[ORM\Column]//Annotation de l'ORM pour la colonne
    private ?int $id = null;// Attribut id de type null

    #[ORM\Column(length: 255)]// Annotation de l'ORM pour la colonne avec une longueur de 255
    #[Assert\NotBlank(message: 'Veuillez renseigner votre nom.')]//Régle de validation
    #[Assert\Length(min: 2, max: 255)]//Régle de validation
    private ?string $nom = null;//Attribut nom de type String qui peut etre null

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner votre prénom.')]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email(message: 'L\'adresse email "{{ value }}" n\'est pas valide.')]
    #[Assert\NotBlank(message: 'Veuillez renseigner votre email.')]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 10, max: 20)]
    private ?string $telephone = null;

    #[ORM\Column]
    private array $roles = [];

   
    #[ORM\Column]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string//Récupére la valeur de la propriété nom
    {
        return $this->nom;//Retourne l'attribur nom
    }

    public function setNom(string $nom): static//Permet de modifier la propriéré
    {
        $this->nom = $nom;//Propriété de l'objet

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    
    public function getRoles(): array
    {
        $roles = $this->roles;
       
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

   
    public function eraseCredentials(): void
    {
        
    }
}