<?php
// src/Controller/HomeController.php

namespace App\Controller;

use App\Repository\PortfolioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PortfolioRepository $portfolioRepository): Response
    {
        // On récupère les 6 derniers projets du portfolio pour les afficher
        $latestProjects = $portfolioRepository->findBy([], ['id' => 'DESC'], 6);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'projects' => $latestProjects,
        ]);
    }
}