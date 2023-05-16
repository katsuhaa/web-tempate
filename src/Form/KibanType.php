<?php

namespace App\Form;

use App\Entity\Kiban;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;



class KibanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('various', ChoiceType::class, [
                'label' => "種別",
                'choices' => [ 'main' => 'main', 'sub' => 'sub', 'wl' => 'wl' ],
            ])
            ->add('order_data', DateType::class, [
                'label' => '発注日',
                'required' => false,
            ])
            ->add('due_date', DateType::class, [
                'label' => '納入予定日',
                'required' => false,
            ])
            ->add('stock_date', DateType::class, [
                'label' => '在庫日',
                'required' => false,
            ])
            ->add('partsno', TextType::class, [
                'label' => 'パーツ番号',
                'required' => false,
            ])
            ->add('serialno', TextType::class, [
                'label' => 'シリアル番号',
                'required' => false,
            ])
            ->add('goodproduct', TextType::class, [
                'label' => '良品・不良品',
                'required' => false,
            ])
            ->add('furikae', TextType::class, [
                'label' => '振替可否',
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'label' => '使用状況',
                'choices' => [ '' => '__unselected', '未使用' => '未使用' ]
            ])
            ->add('nxtperson', TextType::class, [
                'label' => 'NXT担当者',
                'required' => false,
            ])
            ->add('assignee', TextType::class, [
                'label' => '割り当て先',
                'required' => false,
            ])
            ->add('person', TextType::class, [
                'label' => '割り当て先担当者',
                'required' => false,
            ])
            ->add('assigned', CheckboxType::class, [
                'label' => '割り当て済み',
                'required' => false,
            ])
            ->add('memo', TextType::class, [
                'label' => '備考',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Kiban::class,
        ]);
    }
}
