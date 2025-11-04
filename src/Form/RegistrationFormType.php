<?php
// src/Form/RegistrationFormType.php

namespace App\Form;

use App\Entity\Service;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;//Importe les prestations
use Symfony\Component\Form\AbstractType;//Classe obligatoire de symfony
use Symfony\Component\Form\Extension\Core\Type\DateType;// Selecteur de date
use Symfony\Component\Form\Extension\Core\Type\EmailType;//Champ pour les emails
use Symfony\Component\Form\Extension\Core\Type\TelType;//Champ pour les numeros de tel
use Symfony\Component\Form\Extension\Core\Type\TextType;//Champ pour le texte
use Symfony\Component\Form\FormBuilderInterface;// Construction du formulaire
use Symfony\Component\OptionsResolver\OptionsResolver;//Configuration du formulaire
use Symfony\Component\Validator\Constraints\NotBlank;//Régle de validation: Contrainte
use Symfony\Component\Validator\Constraints\Count;//Régle de validation

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void//Fonction principale

    {
        $builder//Permet d'ajouter un champ
            ->add('prenom', TextType::class, [//Ajout du champ du prénom
                'label' => 'Prénom :',//Affichage du texte
                'attr' => ['placeholder' => '']//Ajouts des attributs
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom :',
                'attr' => ['placeholder' => '']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email :',
                'attr' => ['placeholder' => '']
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone :',
                'attr' => ['placeholder' => '']
            ])
            ->add('date', DateType::class, [
                'label' => 'Date souhaitée pour le rendez-vous',
                'widget' => 'single_text',//Demande d'afficher un calendrier
                'attr' => ['class' => 'form-control'],//Class venant de Bootstrap
                'mapped' => false, // Ce champ n'est pas lié à l'entité User
            ])
            ->add('services', EntityType::class, [
                'class' => Service::class,
                'choice_label' => function(Service $service) {//Crée une étiquette personnalisée
                    return sprintf('%s - %s €', $service->getNom(), number_format($service->getPrix(), 2));
                },
                'multiple' => true,//Plusieurs services possible
                'expanded' => true, // Pour afficher des cases à cocher
                'label' => false,//Cache le libelle du groupe case à cocher
                'mapped' => false, // Ce champ n'est pas lié à l'entité User
                'constraints' => [
                    new Count([//Obligation de cocher au moin 1 case, sinon message d'erreur
                        'min' => 1,
                        'minMessage' => 'Vous devez sélectionner au moins une prestation.',
                    ]),
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,//Connecte le formulaire à mon entité User
        ]);
    }
}