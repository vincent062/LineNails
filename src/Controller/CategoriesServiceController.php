<?php

namespace App\Controller;

use App\Entity\CategoriesService;
use App\Form\CategoriesServiceType;
use App\Repository\CategoriesServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories/service')]
final class CategoriesServiceController extends AbstractController
{
    #[Route(name: 'app_categories_service_index', methods: ['GET'])]
    public function index(CategoriesServiceRepository $categoriesServiceRepository): Response
    {
        return $this->render('categories_service/index.html.twig', [
            'categories_services' => $categoriesServiceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categories_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoriesService = new CategoriesService();
        $form = $this->createForm(CategoriesServiceType::class, $categoriesService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categoriesService);
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories_service/new.html.twig', [
            'categories_service' => $categoriesService,
            'form' => $form,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_categories_service_show', methods: ['GET'])]
    public function show(CategoriesService $categoriesService): Response
    {
        return $this->render('categories_service/show.html.twig', [
            'categories_service' => $categoriesService,
        ]);
    }

    #[Route('/{id<\d+>}/edit', name: 'app_categories_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoriesService $categoriesService, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoriesServiceType::class, $categoriesService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories_service/edit.html.twig', [
            'categories_service' => $categoriesService,
            'form' => $form,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_categories_service_delete', methods: ['POST'])]
    public function delete(Request $request, CategoriesService $categoriesService, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoriesService->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($categoriesService);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categories_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
