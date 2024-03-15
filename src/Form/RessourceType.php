<?php

namespace App\Form;

use App\Entity\Ressource;
use App\Entity\Category;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\TextType;
use Stringable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TypeTextType::class ,['label' => 'Titre : ',
            'attr' => array('class' => 'inputstyle form-control '), 'required' => true,])
            ->add('fichier', FileType::class, [
                'label' => 'Fichiers de téléchargeable : ',
                'label_attr' => array('class' => 'label'),
                'attr' => array('class' => 'inputstyle form-control'),
                'mapped' => false,
                'required' => true,
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
            ->add('description', TextareaType::class ,['label' => 'Descripition : ','attr' => array('class' => 'inputstyle'), 'required' => true])
            ->add('image', FileType::class, [
                'label' => 'Image de presentation : ',
                'attr' => array('class' => 'inputstyle  form-control'),
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => ' Votre fichier n\'est pas une image valide',
                    ])
                ],
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Oui' => 1,
                    'Non' => 0,],
                'label' => 'Contenue téléchargeable : ', 
                'attr' => array('class' => 'inputstyle form-control '),
                'required' => true])
            ->add('private', null, ['label' => 'Mettre en ligne : ','attr' => array('class' => 'inputstyle checkboxstyle'), 'required' => true])
            ->add('category', EntityType::class, [
                'label'=> 'Categorie : ',
                'attr' => array('class' => 'inputstyle form-control '),
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
