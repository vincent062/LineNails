<?php
// src/Controller/RegistrationController.php
namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;//Formulaire d'inscription
use Doctrine\ORM\EntityManagerInterface;//Permet de sauvegarder en BDD
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;//Gére les requétes
use Symfony\Component\HttpFoundation\Response;//Gére les réponses
use Symfony\Component\Mailer\MailerInterface;//Envois d'email
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;//Définis l'URL
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;//Crypter les mots de passe
use Symfony\Component\Uid\Uuid;//Génére des identifiants aléatoires

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]// Crée l'URL de ma page

     // Injection de dépendances avec Request
     public function register(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, UserPasswordHasherInterface $passwordHasher): Response
    {    
        
        $user = new User();//nouvel objet user vide
        $form = $this->createForm(RegistrationFormType::class, $user);//

        $form->handleRequest($request);//Récupére les données 

        if ($form->isSubmitted() && $form->isValid()) {
            // Générer un mot de passe aléatoire et sécurisé
            $randomPassword = Uuid::v4()->toBase32(); // Crée une chaîne de caractères aléatoire
            
            // Hasher et définir le mot de passe pour l'utilisateur
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $randomPassword
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            // Récupération des données du formulaire
            $selectedServices = $form->get('services')->getData();
            $date = $form->get('date')->getData();

            // Création du corps de l'e-mail à partir du template
            $emailBody = $this->renderView('emails/registration.html.twig', [
                'user' => $user,
                'services' => $selectedServices,
                'date' => $date,
            ]);

            // Création et envoi de l'e-mail
            $email = (new Email())
                ->from('no-reply@LineNails.com')//Définir l'expediteur
                ->to($user->getEmail())//Récupération de l'email du destinataire
                ->subject('Confirmation de votre demande de rendez-vous')
                ->html($emailBody);

            $mailer->send($email);//Envoie de l'email

            $this->addFlash('success', 'Votre demande de rendez-vous a bien été envoyée ! Un e-mail de confirmation vous a été adressé.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}