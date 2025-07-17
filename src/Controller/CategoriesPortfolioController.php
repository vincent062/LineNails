<?php

namespace App\Controller;

use App\Entity\CategoriesPortfolio;
use App\Form\CategoriesPortfolioType;
use App\Repository\CategoriesPortfolioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories/portfolio')]
final class CategoriesPortfolioController extends AbstractController
{
    #[Route(name: 'app_categories_portfolio_index', methods: ['GET'])]
    public function index(CategoriesPortfolioRepository $categoriesPortfolioRepository): Response
    {
        return $this->render('categories_portfolio/index.html.twig', [
            'categories_portfolios' => $categoriesPortfolioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categories_portfolio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoriesPortfolio = new CategoriesPortfolio();
        $form = $this->createForm(CategoriesPortfolioType::class, $categoriesPortfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categoriesPortfolio);
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_portfolio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories_portfolio/new.html.twig', [
            'categories_portfolio' => $categoriesPortfolio,
            'form' => $form,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_categories_portfolio_show', methods: ['GET'])]
    public function show(CategoriesPortfolio $categoriesPortfolio): Response
    {
        return $this->render('categories_portfolio/show.html.twig', [
            'categories_portfolio' => $categoriesPortfolio,
        ]);
    }

    #[Route('/{id<\d+>}/edit', name: 'app_categories_portfolio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoriesPortfolio $categoriesPortfolio, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoriesPortfolioType::class, $categoriesPortfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_portfolio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories_portfolio/edit.html.twig', [
            'categories_portfolio' => $categoriesPortfolio,
            'form' => $form,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_categories_portfolio_delete', methods: ['POST'])]
    public function delete(Request $request, CategoriesPortfolio $categoriesPortfolio, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoriesPortfolio->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($categoriesPortfolio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categories_portfolio_index', [], Response::HTTP_SEE_OTHER);
    }
}
