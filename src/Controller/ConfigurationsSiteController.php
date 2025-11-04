<?php

namespace App\Controller;

use App\Entity\ConfigurationsSite;// Entité Doctrine
use App\Form\ConfigurationsSiteType;// Formulaire symfony pour créer ou modifier une réalisation
use App\Repository\ConfigurationsSiteRepository;//La classe pour récupérer les réalisations depuis la base de données
use Doctrine\ORM\EntityManagerInterface;// Permet de sauvegarder ou supprimer des entités
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;// Classe de base pour les controlleurs
use Symfony\Component\HttpFoundation\Request;// Requéte HTTP entrante
use Symfony\Component\HttpFoundation\Response;// Réponse HTTP que le controlleur renvois
use Symfony\Component\Routing\Attribute\Route;// Attribut pour définir les URL du controlleur
use Symfony\Component\Security\Http\Attribute\IsGranted;// Attribut pour restreindre l'accés 

#[Route('/configurations/site')]// Route permettant d'accéder à configurationsSite
#[IsGranted('ROLE_ADMIN')] // permet de bloquer toutes mes routes en les rendant inaccessibles aux utilisateurs lambda.
final class ConfigurationsSiteController extends AbstractController
{
    #[Route(name: 'app_configurations_site_index', methods: ['GET'])]
    public function index(ConfigurationsSiteRepository $configurationsSiteRepository): Response
    {
        return $this->render('configurations_site/index.html.twig', [
            'configurations_sites' => $configurationsSiteRepository->findAll(),// Utilise le répertoire pour recupérer toutes les réalisations
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
