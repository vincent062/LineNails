<?php
// src/Controller/RegistrationController.php
namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
                ->from('no-reply@linenails.com')
                ->to($user->getEmail())
                ->subject('Confirmation de votre demande de rendez-vous')
                ->html($emailBody);

            $mailer->send($email);

            $this->addFlash('success', 'Votre demande de rendez-vous a bien été envoyée ! Un e-mail de confirmation vous a été adressé.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}