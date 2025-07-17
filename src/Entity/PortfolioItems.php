<?php

namespace App\Form;

use App\Entity\CategoriesPortfolio; 
use App\Entity\PortfolioItems;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PortfolioItemsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('image_url')
            ->add('description')
            ->add('date_creation')
            ->add('ordre_affichage')
            ->add('est_actif')
            
            ->add('categoriePortfolio', EntityType::class, [ // Assurez-vous que le nom 'categoriePortfolio' correspond à la propriété dans l'entité PortfolioItems
                'class' => CategoriesPortfolio::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie du portfolio',
                'placeholder' => 'Choisissez une catégorie', 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PortfolioItemsType::class,
        ]);
    }
}
