<?php

namespace App\Form;

use App\Entity\ChPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ChPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('no', HiddenType::class, [
            ])
            ->add('name')
            ->add('postdata', TextareaType::class, [
                'required' => 'true'
            ])
            ->add('thread_id', HiddenType::class)
            ->add('date', DateTimeType::class, [
                'disabled' => 'true',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'with_seconds' => 'true',
            ])
            ->add('metadata', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChPost::class,
        ]);
    }
}
