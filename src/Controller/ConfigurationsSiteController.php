<?php

namespace App\Controller;

use App\Entity\ConfigurationsSite;
use App\Form\ConfigurationsSiteType;
use App\Repository\ConfigurationsSiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/configurations/site')]
#[IsGranted('ROLE_ADMIN')]
final class ConfigurationsSiteController extends AbstractController
{
    #[Route(name: 'app_configurations_site_index', methods: ['GET'])]
    public function index(ConfigurationsSiteRepository $configurationsSiteRepository): Response
    {
        return $this->render('configurations_site/index.html.twig', [
            'configurations_sites' => $configurationsSiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_configurations_site_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $configurationsSite = new ConfigurationsSite();
        $form = $this->createForm(ConfigurationsSiteType::class, $configurationsSite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($configurationsSite);
            $entityManager->flush();

            return $this->redirectToRoute('app_configurations_site_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('configurations_site/new.html.twig', [
            'configurations_site' => $configurationsSite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_configurations_site_show', methods: ['GET'])]
    public function show(ConfigurationsSite $configurationsSite): Response
    {
        return $this->render('configurations_site/show.html.twig', [
            'configurations_site' => $configurationsSite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_configurations_site_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ConfigurationsSite $configurationsSite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConfigurationsSiteType::class, $configurationsSite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_configurations_site_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('configurations_site/edit.html.twig', [
            'configurations_site' => $configurationsSite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_configurations_site_delete', methods: ['POST'])]
    public function delete(Request $request, ConfigurationsSite $configurationsSite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$configurationsSite->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($configurationsSite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_configurations_site_index', [], Response::HTTP_SEE_OTHER);
    }
}
