<?php

namespace App\Form;

use App\Entity\ConfigurationsSite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurationsSiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_config')
            ->add('adresse_postale')
            ->add('telephone')
            ->add('email_contact')
            ->add('horaires_ouverture')
            ->add('url_page_facebook')
            ->add('url_page_instgram')
            ->add('url_prise_rdv_facebook')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConfigurationsSite::class,
        ]);
    }
}
