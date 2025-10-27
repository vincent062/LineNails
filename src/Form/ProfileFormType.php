<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\PasswordStrength; // Ajouté pour la force du mdp

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('newEmail', EmailType::class, [
                'label' => 'Nouvelle adresse e-mail (laisser vide pour ne pas changer)',
                'required' => false,
                'mapped' => false, // Non lié directement à une propriété User, on le gère manuellement
                'attr' => [
                    'placeholder' => $options['current_email'] ?? 'Votre email actuel',
                    'autocomplete' => 'email'
                 ],
            ])
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel (requis pour changer de mot de passe)',
                'required' => false, // Rendu optionnel car on ne change pas forcément le mdp
                'mapped' => false,
                'attr' => ['autocomplete' => 'current-password'],
            ])
             // Utilise RepeatedType pour avoir "Nouveau mot de passe" et "Confirmer le nouveau mot de passe"
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => false, // Le changement de mdp est optionnel
                'first_options' => [
                    'label' => 'Nouveau mot de passe (laisser vide pour ne pas changer)',
                    'attr' => ['autocomplete' => 'new-password'],
                    'constraints' => [
                        // On applique les contraintes seulement si le champ n'est pas vide
                        // (Permet de laisser vide sans erreur)
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                        new PasswordStrength([ // Vérifie la force du mot de passe
                            'minScore' => PasswordStrength::STRENGTH_MEDIUM, // Score minimum requis (faible, moyen, fort, très fort)
                             'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.'
                        ]),
                         new NotCompromisedPassword(), // Vérifie si le mdp a fuité
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer le nouveau mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'invalid_message' => 'Les champs du nouveau mot de passe doivent correspondre.',
                 // Ne sera validé que si au moins un des champs 'newPassword' est rempli.
                 // Et si currentPassword est aussi rempli.
                 // La logique de validation plus fine (ex: currentPassword requis si newPassword rempli)
                 // se fera plutôt dans le contrôleur ou avec des contraintes de classe.
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Pas de data_class car on ne lie pas directement à l'entité User ici
             'current_email' => null, // Option pour passer l'email actuel au formulaire
        ]);
        // Permet de passer l'email actuel en option lors de la création du form
         $resolver->setAllowedTypes('current_email', ['null', 'string']);
    }
}