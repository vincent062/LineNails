<?php

namespace App\Entity;    //Namespace de l'entité

use App\Repository\ConfigurationsSiteRepository; //Importation de la classe ConfigurationsSiteRepository
use Doctrine\DBAL\Types\Types; //Importation de la classe Types
use Doctrine\ORM\Mapping as ORM; //Importation des outils de Mapping de Doctrine

#[ORM\Entity(repositoryClass: ConfigurationsSiteRepository::class)] //Annotation de l'entité
class ConfigurationsSite
{
    #[ORM\Id] //Annotation de l'attribut id
    #[ORM\GeneratedValue] //Annotation de l'ORM pour l'auto-incrémentation
    #[ORM\Column] //Annotation de l'ORM pour la colonne
    private ?int $id = null; // Attribut id de type int

    #[ORM\Column(length: 255)] // Annotation de l'ORM pour la colonne avec une longueur de 255
    private ?string $adresse_postale = null; // Attribut adresse_postale de type string qui peut être null

    #[ORM\Column(length: 255)] // Annotation de l'ORM pour la colonne avec une longueur de 255
    private ?string $telephone = null; // Attribut telephone de type string qui peut être null

    #[ORM\Column(length: 255)]
    private ?string $email_contact = null;

    #[ORM\Column(type: Types::TEXT)] // Annotation de l'ORM pour la colonne de type TEXT qui peut être null
    private ?string $horaires_ouverture = null; // Attribut horaires_ouverture de type string qui peut être null

    #[ORM\Column(length: 255)]
    private ?string $url_page_facebook = null;

    #[ORM\Column(length: 255)]
    private ?string $url_page_instgram = null;

    #[ORM\Column(length: 255)]
    private ?string $url_prise_rdv_facebook = null;

    // get permet de récupérer la valeur d'un attribut
   // set permet de modifier la valeur d'un attribut

    public function getId(): ?int
    {
        return $this->id; // Retourne l'attribut id
    }

    public function getAdressePostale(): ?string // Méthode getAdressePostale de type string
    {
        return $this->adresse_postale; // Retourne l'attribut adresse_postale
    }

    public function setAdressePostale(string $adresse_postale): static // Méthode setAdressePostale de type string
    {
        $this->adresse_postale = $adresse_postale; // Attribut adresse_postale prend la valeur de l'argument adresse_postale

        return $this; // Retourne l'objet
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->email_contact;
    }

    public function setEmailContact(string $email_contact): static
    {
        $this->email_contact = $email_contact;

        return $this;
    }

    public function getHorairesOuverture(): ?string
    {
        return $this->horaires_ouverture;
    }

    public function setHorairesOuverture(string $horaires_ouverture): static
    {
        $this->horaires_ouverture = $horaires_ouverture;

        return $this;
    }

    public function getUrlPageFacebook(): ?string
    {
        return $this->url_page_facebook;
    }

    public function setUrlPageFacebook(string $url_page_facebook): static
    {
        $this->url_page_facebook = $url_page_facebook;

        return $this;
    }

    public function getUrlPageInstgram(): ?string
    {
        return $this->url_page_instgram;
    }

    public function setUrlPageInstgram(string $url_page_instgram): static
    {
        $this->url_page_instgram = $url_page_instgram;

        return $this;
    }

    public function getUrlPriseRdvFacebook(): ?string
    {
        return $this->url_prise_rdv_facebook;
    }

    public function setUrlPriseRdvFacebook(string $url_prise_rdv_facebook): static
    {
        $this->url_prise_rdv_facebook = $url_prise_rdv_facebook;

        return $this;
    }
}
