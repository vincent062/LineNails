<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom :',
                'attr' => ['placeholder' => '']
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom :',
                'attr' => ['placeholder' => '']
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail :',
                'attr' => ['placeholder' => '']
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone :',
                'attr' => ['placeholder' => '']
            ])
            ->add('date', DateType::class, [
                'label' => 'Date du rendez-vous :',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
            ])
            ->add('services', EntityType::class, [
                'class' => Service::class,
                'choice_label' => function(Service $service) {
                    return sprintf('%s - %s €', $service->getNom(), number_format($service->getPrix(), 2));
                },
                'multiple' => true,
                'expanded' => true,
                'label' => false,
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}