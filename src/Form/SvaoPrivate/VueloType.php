<?php

namespace App\Form\SvaoPrivate;

use App\Entity\SvaoPrivate\Aerolinea;
use App\Entity\SvaoPrivate\Ciudad;
use App\Entity\SvaoPrivate\MarcaAvion;
use App\Entity\SvaoPrivate\ModeloAvion;
use App\Entity\SvaoPrivate\TipoAvion;
use App\Entity\SvaoPrivate\Vuelo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class VueloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo',TextType::class,['attr'=>['readonly'=>true]])

            ->add('tiempoVuelo',NumberType::class,[
                    'attr'=>['placeholder'=>'0.0'],
                    'constraints'=>[new NotBlank()]
            ])
            ->add('costoViaje',NumberType::class,
                [
                    'attr'=>['placeholder'=>'0.0'],
                    'constraints'=>[new NotBlank()]
                ]
            )
            ->add('precio',NumberType::class,
                [
                    'attr'=>['placeholder','0.0'],
                    'constraints'=>[New NotBlank()]
                ]
            )
            ->add('millasAsignables',NumberType::class,
                    [
                        'attr'=>['0.0'],
                        'constraints'=>[new NotBlank()]
                    ]
                )
            ->add('millasReal',NumberType::class,[
                'attr'=>['placeholder'=>"0.0"],
                'constraints'=>[new NotBlank()]
                ])
            ->add('origen',EntityType::class,
                [
                    'class'=>Ciudad::class,
                    'placeholder'=>'Seleccione destino',
                    'choice_label'=>'nombre',
                    'constraints'=>[new NotBlank()]
                ])
            ->add('destino',EntityType::class,
                [
                    'class'=>Ciudad::class,
                    'placeholder'=>'Seleccione destino',
                    'choice_label'=>'nombre',
                    'constraints'=>[new NotBlank()]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vuelo::class,
        ]);
    }
}
