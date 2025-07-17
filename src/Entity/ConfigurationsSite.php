<?php

namespace App\Entity;

use App\Repository\ConfigurationsSiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigurationsSiteRepository::class)]
class ConfigurationsSite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_postale = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $email_contact = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $horaires_ouverture = null;

    #[ORM\Column(length: 255)]
    private ?string $url_page_facebook = null;

    #[ORM\Column(length: 255)]
    private ?string $url_page_instgram = null;

    #[ORM\Column(length: 255)]
    private ?string $url_prise_rdv_facebook = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdressePostale(): ?string
    {
        return $this->adresse_postale;
    }

    public function setAdressePostale(string $adresse_postale): static
    {
        $this->adresse_postale = $adresse_postale;

        return $this;
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
