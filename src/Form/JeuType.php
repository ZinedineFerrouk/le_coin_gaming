<?php

namespace App\Form;

use App\Entity\Jeu;
use App\Entity\Plateforme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('date_sortie')
            ->add('image')
            ->add('plateforme', EntityType::class,[
                'class' => Plateforme::class,
                'choice_label' => 'titre',
                'multiple' => true,
                'expanded' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jeu::class,
        ]);
    }
}
