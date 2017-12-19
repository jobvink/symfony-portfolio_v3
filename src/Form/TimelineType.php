<?php

namespace App\Form;

use App\Entity\Competence;
use App\Entity\Timeline;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimelineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('employer')
            ->add('function')
            ->add('description')
            ->add('beginDate')
            ->add('endDate')
            ->add('logo', FileType::class, [
                'data_class' => null,
                'label' => false,
                'attr' => [
                    'class' => 'u-hidden',
                    'data-entity' => 'competence'
                ]
            ]);    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
//             uncomment if you want to bind to a class
            'data_class' => Timeline::class,
        ]);
    }
}
