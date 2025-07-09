<?php

namespace App\Controller;

use App\Entity\PortfolioItems;
use App\Form\PortfolioItemsType;
use App\Repository\PortfolioItemsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/portfolio/items')]
final class PortfolioItemsController extends AbstractController
{
    #[Route(name: 'app_portfolio_items_index', methods: ['GET'])]
    public function index(PortfolioItemsRepository $portfolioItemsRepository): Response
    {
        return $this->render('portfolio_items/index.html.twig', [
            'portfolio_items' => $portfolioItemsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_portfolio_items_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $portfolioItem = new PortfolioItems();
        $form = $this->createForm(PortfolioItemsType::class, $portfolioItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($portfolioItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_portfolio_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('portfolio_items/new.html.twig', [
            'portfolio_item' => $portfolioItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portfolio_items_show', methods: ['GET'])]
    public function show(PortfolioItems $portfolioItem): Response
    {
        return $this->render('portfolio_items/show.html.twig', [
            'portfolio_item' => $portfolioItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_portfolio_items_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PortfolioItems $portfolioItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PortfolioItemsType::class, $portfolioItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_portfolio_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('portfolio_items/edit.html.twig', [
            'portfolio_item' => $portfolioItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portfolio_items_delete', methods: ['POST'])]
    public function delete(Request $request, PortfolioItems $portfolioItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portfolioItem->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($portfolioItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_portfolio_items_index', [], Response::HTTP_SEE_OTHER);
    }
}
