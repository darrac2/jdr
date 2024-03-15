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
                    'Sélectionnez un motif' => "0",
                    "Pédopornographie" => "Pédopornographie",
                    'Pédopornographie' => 'Propos haineux, discrimination, négationnisme',
                    'Menaces physiques '=> 'Menaces physiques ',
                    "Piratage, non respect des droits d'auteurs"=> "Piratage, non respect des droits d'auteur",
                    "Apologie de comportements illégaux"=>"Apologie de comportements illégaux",
                    "Terrorisme : menace ou apologie"=>"Terrorisme : menace ou apologie",
                    "Raid, flood, attaque de sites"=>"Raid, flood, attaque de sites",
                    "Pornographie"=>"Pornographie",
                    "Insulte, diffamation"=>"Insulte, diffamation",
                    "Spoilers"=>"Spoilers",
                    "Image ou vidéo choquante, gore"=>"Image ou vidéo choquante, gore",
                    "Données personnelles"=>"Données personnelles",
                    "Suicide ou automutilation"=>"Suicide ou automutilation",
                    "Message inopportun"=>"Message inopportun",
                    "Publicité"=>"Publicité",
                    "Autre"=>"Autre",
                ],
                'label' => 'Motif : ', 
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
