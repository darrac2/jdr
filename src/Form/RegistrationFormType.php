<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, ['attr'=>[
                'label' => false,
                'label_html' => false,
                'class'=>'form-control registerpseudo',
                'placeholder'=>'Pseudo']])
            ->add('email', EmailType::class, [
                'label' => false,
                'label_html' => false,
                'attr' => ['class'=>'form-control registeremail',
                'placeholder'=>'Adresse mail' ]])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field registerpassword form-control','placeholder'=>'Mot de passe']],
                'required' => true,
                'first_options'  => ['label' => false, 'label_html' => false],
                'second_options' => ['label' => false,'label_html' => false],
                'attr' => array('class' => 'form-group registerpasswordsecond'),
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'attr'=>['class'=>'registercheck col-sm'],
                'mapped' => false,
                'label' => false,
                'label_html' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les terme d&#39;utilisation.',
                    ]),
                ],
            ])
            ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
