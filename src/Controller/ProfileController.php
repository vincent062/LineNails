<?php

namespace App\Controller;

use App\Form\ProfileFormType; // On importera ce formulaire qu'on va créer
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/profil')] // Préfixe de route pour ce contrôleur
#[IsGranted('ROLE_ADMIN')] // Sécurise toutes les routes de ce contrôleur pour l'admin
class ProfileController extends AbstractController
{
    #[Route('/modifier', name: 'app_admin_profile_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response
    {
        // Récupère l'utilisateur actuellement connecté (l'admin)
        /** @var \App\Entity\User|null $user */
        $user = $this->getUser();
        if (!$user) {
            // Normalement impossible à atteindre grâce à IsGranted, mais bonne pratique
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Crée le formulaire et le lie à l'utilisateur actuel
        // On passe l'utilisateur pour pré-remplir l'email
        $form = $this->createForm(ProfileFormType::class, null, [
            'current_email' => $user->getEmail(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData(); // Récupère les données validées (ici un tableau car pas de data_class)

            $emailChanged = false;
            $passwordChanged = false;

            // --- Modification de l'email ---
            if (!empty($data['newEmail'])) {
                // Vérifie si le nouvel email est différent de l'ancien
                if ($data['newEmail'] !== $user->getEmail()) {
                     // Optionnel : Ajouter une vérification si l'email existe déjà pour un autre user
                     // $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['newEmail']]);
                     // if ($existingUser) {
                     //     $this->addFlash('danger', 'Cette adresse e-mail est déjà utilisée par un autre compte.');
                     // } else {
                         $user->setEmail($data['newEmail']);
                         $emailChanged = true;
                     // }
                }
            }

            // --- Modification du mot de passe ---
            $currentPasswordPlain = $data['currentPassword'];
            $newPasswordPlain = $form->get('newPassword')->get('first')->getData(); // Récupérer le mot de passe depuis RepeatedType

            // Si un nouveau mot de passe est saisi
            if (!empty($newPasswordPlain)) {
                // 1. Vérifier si le mot de passe actuel a été saisi ET est correct
                if (empty($currentPasswordPlain)) {
                     $this->addFlash('danger', 'Veuillez saisir votre mot de passe actuel pour définir un nouveau mot de passe.');
                } elseif (!$passwordHasher->isPasswordValid($user, $currentPasswordPlain)) {
                    // Mot de passe actuel incorrect
                    $this->addFlash('danger', 'Le mot de passe actuel est incorrect.');
                } else {
                    // 2. Hasher et enregistrer le nouveau mot de passe
                    $user->setPassword(
                        $passwordHasher->hashPassword(
                            $user,
                            $newPasswordPlain
                        )
                    );
                    $passwordChanged = true;
                }
            } elseif (!empty($currentPasswordPlain) && empty($newPasswordPlain)) {
                 // Si l'ancien mot de passe est saisi mais pas le nouveau (cas bizarre, peut-être une erreur)
                 $this->addFlash('warning', 'Vous avez saisi votre mot de passe actuel mais pas de nouveau mot de passe.');
            }

            // Sauvegarde et message flash seulement si qqch a changé et pas d'erreur de mot de passe
             if (($emailChanged || $passwordChanged) && $form->isValid()) {
                 try {
                    $entityManager->flush();
                    if ($emailChanged) { $this->addFlash('success', 'Votre adresse e-mail a été mise à jour.'); }
                    if ($passwordChanged) { $this->addFlash('success', 'Votre mot de passe a été mis à jour.'); }

                     // Redirige pour éviter resoumission du formulaire en cas de refresh
                     return $this->redirectToRoute('app_admin_profile_edit');

                 } catch (\Exception $e) {
                     // Gérer les erreurs potentielles (ex: email déjà pris si on a ajouté la vérification)
                     $this->addFlash('danger', 'Une erreur est survenue lors de la mise à jour.');
                     // Log l'erreur $e->getMessage();
                 }
            } elseif (!$emailChanged && !$passwordChanged && $form->isValid() && empty($currentPasswordPlain) && empty($newPasswordPlain)) {
                 // Si le formulaire est valide mais rien n'a été modifié
                 $this->addFlash('info', 'Aucune modification n\'a été apportée.');
            }
        }

        // Affiche le formulaire (ou ré-affiche avec erreurs)
        return $this->render('profile/edit.html.twig', [
            'profileForm' => $form->createView(),
        ]);
    }
}