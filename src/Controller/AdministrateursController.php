<?php

namespace App\Controller;

use App\Entity\Administrateurs;
use App\Form\AdministrateursType;
use App\Repository\AdministrateursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/administrateurs')]
final class AdministrateursController extends AbstractController
{
    #[Route(name: 'app_administrateurs_index', methods: ['GET'])]
    public function index(AdministrateursRepository $administrateursRepository): Response
    {
        return $this->render('administrateurs/index.html.twig', [
            'administrateurs' => $administrateursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_administrateurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $administrateur = new Administrateurs();
        $form = $this->createForm(AdministrateursType::class, $administrateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($administrateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_administrateurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('administrateurs/new.html.twig', [
            'administrateur' => $administrateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_administrateurs_show', methods: ['GET'])]
    public function show(Administrateurs $administrateur): Response
    {
        return $this->render('administrateurs/show.html.twig', [
            'administrateur' => $administrateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_administrateurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Administrateurs $administrateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdministrateursType::class, $administrateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_administrateurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('administrateurs/edit.html.twig', [
            'administrateur' => $administrateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_administrateurs_delete', methods: ['POST'])]
    public function delete(Request $request, Administrateurs $administrateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$administrateur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($administrateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_administrateurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
