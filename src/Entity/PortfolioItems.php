<?php

namespace App\Entity;

use App\Repository\PortfolioItemsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortfolioItemsRepository::class)]
class PortfolioItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_item = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $type_media = null;

    #[ORM\Column(length: 255)]
    private ?string $url_fichier = null;

    #[ORM\Column]
    private ?\DateTime $date_ajout = null;

    #[ORM\Column]
    private ?int $id_categorie_portfolio_fk = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdItem(): ?int
    {
        return $this->id_item;
    }

    public function setIdItem(int $id_item): static
    {
        $this->id_item = $id_item;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTypeMedia(): ?string
    {
        return $this->type_media;
    }

    public function setTypeMedia(string $type_media): static
    {
        $this->type_media = $type_media;

        return $this;
    }

    public function getUrlFichier(): ?string
    {
        return $this->url_fichier;
    }

    public function setUrlFichier(string $url_fichier): static
    {
        $this->url_fichier = $url_fichier;

        return $this;
    }

    public function getDateAjout(): ?\DateTime
    {
        return $this->date_ajout;
    }

    public function setDateAjout(\DateTime $date_ajout): static
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }

    public function getIdCategoriePortfolioFk(): ?int
    {
        return $this->id_categorie_portfolio_fk;
    }

    public function setIdCategoriePortfolioFk(int $id_categorie_portfolio_fk): static
    {
        $this->id_categorie_portfolio_fk = $id_categorie_portfolio_fk;

        return $this;
    }
}
