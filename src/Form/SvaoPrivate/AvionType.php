<?php

namespace App\Form\SvaoPrivate;

use App\Entity\SvaoPrivate\Avion;
use App\Entity\SvaoPrivate\MarcaAvion;
use App\Entity\SvaoPrivate\ModeloAvion;
use App\Entity\SvaoPrivate\TipoAvion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AvionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo',TextType::class,
                [
                    'attr'=>['readonly'=>true]
                ])
            ->add('capacidad',NumberType::class,
                [
                'attr'=>['placeholder'=>'00','class'=>'int'],
                'constraints'=>[new NotBlank()],
                ])
            ->add('tipo',EntityType::class,
                [
                    'class'=>TipoAvion::class,
                    'placeholder'=>'Seleccione tipo',
                    'choice_label'=>'nombre',
                    'constraints'=>[new NotBlank()]
                ])
            ->add('modelo',EntityType::class,
                [
                    'class'=>ModeloAvion::class,
                    'placeholder'=>'Seleccione modelo',
                    'choice_label'=>'nombre',
                    'constraints'=>[new NotBlank()]
                ])
            ->add('marca',EntityType::class,
                [
                    'class'=>MarcaAvion::class,
                    'placeholder'=>'Seleccione marca',
                    'choice_label'=>'nombre',
                    'constraints'=>[new NotBlank()]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Avion::class,
        ]);
    }
}
