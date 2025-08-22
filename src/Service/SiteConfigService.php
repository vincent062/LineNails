<?php
// src/Service/SiteConfigService.php

namespace App\Service;

use App\Entity\ConfigurationsSite;
use Doctrine\ORM\EntityManagerInterface;

class SiteConfigService
{
    private ?ConfigurationsSite $config = null;

    public function __construct(private EntityManagerInterface $em) {}

    public function getConfig(): ?ConfigurationsSite
    {
        if ($this->config === null) {
            // On récupère la première (et unique) ligne de configuration
            $this->config = $this->em->getRepository(ConfigurationsSite::class)->findOneBy([]);
        }

        return $this->config;
    }
}