
<?php

namespace App\Form;

use App\Entity\CategoriesService; 
use App\Entity\Services;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('prix')
            ->add('duree_minutes')
            ->add('est_actif')
           
            ->add('categorieService', EntityType::class, [
                'class' => CategoriesService::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'placeholder' => 'Choisissez une catégorie', 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}