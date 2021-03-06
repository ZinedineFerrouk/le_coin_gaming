<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Jeu;
use App\Entity\Plateforme;
use App\Repository\JeuRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix')
            ->add('boite')
            ->add('jeu', EntityType::class,[
                'class' => Jeu::class,
                'query_builder' => function (JeuRepository $er) {
                    return $er->createQueryBuilder('j')
                        ->where('j.status = :status')
                        ->setParameter('status', 'Publié');
                },
                
                'choice_label' => 'titre',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('plateforme', EntityType::class,[
                'class' => Plateforme::class,
                'choice_label' => 'titre',
                'multiple' => false,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
