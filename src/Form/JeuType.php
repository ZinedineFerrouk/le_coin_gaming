<?php

namespace App\Form;

use App\Entity\Jeu;
use App\Entity\Plateforme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class JeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextareaType::class, [
                'required' => true
            ])

            ->add('description')
            ->add('date_sortie')
            
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [

                    new File([
                        'maxSize' => '1000k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Le type de l\'image n\'est pas valide.',
                        'maxSizeMessage' => 'La taille de l\'image n\'est pas conforme.',
                    ])
                ]
            ])
            ->add('plateforme', EntityType::class, [
                'class' => Plateforme::class,
                'choice_label' => 'titre',
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Non Publié' => 'Non-Publié',
                    'Publié' => 'Publié'
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Status'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jeu::class,
        ]);
    }
}
