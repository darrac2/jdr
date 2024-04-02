<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'attr' => array('class' => 'inputstyle form-control'),
            ])
            ->add('profil_image', FileType::class, [
                'label' => 'Modifier mon avatar',
                'attr' => array('class' => 'inputstyle form-control'),
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/bmp',
                            'image/tiff',
                            'image/svg+xml',
                            'image/webp',
                            'image/x-icon',
                        ],
                        'mimeTypesMessage' => 'Votre fichier n\'est pas une image valide',
                    ])
                ],
            ])
            ->add('pseudo', TextType::class,[
                'attr' => array('class' => 'inputstyle form-control'),
            ])
            ->add('description', TextareaType::class,[
                'required' => false,
                'attr' => array('class' => 'inputstyle form-control'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
