<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'required' => false,
                'label' => 'Nom de la vidéo',
                'attr' => [
                    'placeholder' => 'Taper le nom ici...'
                ]
            ])
            ->add('codeYoutube',TextType::class,[
                'required' => false,
                'label' => 'Code youtube de la vidéo',
                'attr' => [
                    'placeholder' => 'Taper le code ici...'
                ]
            ])
            ->add('image',TextType::class,[
                'required' => false,
                'label' => 'Image de présentation',
                'attr' => [
                    'placeholder' => 'Chemin de l\'image...'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
