<?php

namespace App\Controller; // Définis le namespace de la classe

use App\Entity\Portfolio; // Entité Doctrine
use App\Form\PortfolioType; // Formulaire symfony pour créer ou modifier une réalisation
use App\Repository\PortfolioRepository; //La classe pour récupérer les réalisations depuis la base de données
use Doctrine\ORM\EntityManagerInterface; // Permet de sauvegarder ou supprimer des entités
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Classe de base pour les controlleurs
use Symfony\Component\HttpFoundation\Request; // Requéte HTTP entrante
use Symfony\Component\HttpFoundation\Response; // Réponse HTTP que le controlleur renvois
use Symfony\Component\Routing\Attribute\Route; // Attribut pour définir les URL du controlleur
use Symfony\Component\Security\Http\Attribute\IsGranted; // Attribut pour restreindre l'accés 

#[Route('/portfolio')] // Route permettant d'accéder à portfolio
final class PortfolioController extends AbstractController 
{
    #[Route(name: 'app_portfolio_index', methods: ['GET'])]
    public function index(PortfolioRepository $portfolioRepository): Response
    {
        return $this->render('portfolio/index.html.twig', [
            'portfolios' => $portfolioRepository->findAll(), // Utilise le répertoire pour recupérer toutes les réalisations
        ]);
    }

    #[Route('/new', name: 'app_portfolio_new', methods: ['GET', 'POST'])]
     #[IsGranted('ROLE_ADMIN')] // <-- Protège cette route
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $portfolio = new Portfolio();
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($portfolio);
            $entityManager->flush();

            return $this->redirectToRoute('app_portfolio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('portfolio/new.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portfolio_show', methods: ['GET'])]
    public function show(Portfolio $portfolio): Response
    {
        return $this->render('portfolio/show.html.twig', [
            'portfolio' => $portfolio,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_portfolio_edit', methods: ['GET', 'POST'])]
     #[IsGranted('ROLE_ADMIN')] // <-- Protège cette route
    public function edit(Request $request, Portfolio $portfolio, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_portfolio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('portfolio/edit.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portfolio_delete', methods: ['POST'])]
     #[IsGranted('ROLE_ADMIN')] // <-- Protège cette route
    public function delete(Request $request, Portfolio $portfolio, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portfolio->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($portfolio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_portfolio_index', [], Response::HTTP_SEE_OTHER);
    }
}
