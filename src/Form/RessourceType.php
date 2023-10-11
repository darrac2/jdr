<?php

namespace App\Form;

use App\Entity\Ressource;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('fichier', FileType::class, [
                'label' => 'Image de presentation',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/zip',
                            'application/pdf',
                            'application/x-pdf',
                            
                        ],
                        'mimeTypesMessage' => 'Votre fichier n\'est pas au format validé',
                    ])
                ],
            ])
            ->add('description')
            ->add('image', FileType::class, [
                'label' => 'Fichier de téléchargeable',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => ' Votre fichier n\'est pas une image valide',
                    ])
                ],
            ])
            ->add('status')
            ->add('private')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name', ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
        ]);
    }
}
