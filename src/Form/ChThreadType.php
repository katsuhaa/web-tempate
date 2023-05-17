<?php

namespace App\Form;

use App\Entity\ChThread;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChThreadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('thread_title')
            ->add('name')
            ->add('parent_id')
            ->add('create_date')
            ->add('update_date')
            ->add('metadata')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChThread::class,
        ]);
    }
}
