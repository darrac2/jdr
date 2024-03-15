<?php

namespace App\Form;

use App\Entity\Signalementforumcommentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignalementforumcommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sujet', ChoiceType::class, [
                'choices'  => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'label' => 'Contenue téléchargeable : ', 
                'attr' => array('class' => 'inputstyle form-control '),
                'required' => true])
            ->add('forumcommentaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Signalementforumcommentaire::class,
        ]);
    }
}
