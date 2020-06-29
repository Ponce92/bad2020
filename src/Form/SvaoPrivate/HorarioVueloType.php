<?php

namespace App\Form\SvaoPrivate;

use App\Entity\SvaoPrivate\Avion;
use App\Entity\SvaoPrivate\HorarioVuelo;
use App\Entity\SvaoPrivate\Pais;
use App\Entity\SvaoPrivate\Vuelo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class HorarioVueloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['opt']=='arp'){

            $builder->add('gateway',IntegerType::class,[

                'constraints'=>[new NotBlank()]
            ])

            ->add('fecha',DateType::class,[
                'format'=>'dd MM yyyy',
                'attr'=>['readonly'=>'readonly'],
                'constraints'=>[new NotBlank()]
            ])
            ->add('hora',TimeType::class,[
                'placeholder'=>['hour'=>'Hora','minute'=>'Min'],
                'attr'=>['readonly'=>true],
                'constraints'=>[new NotBlank()]
            ])
            ->add('vuelo',EntityType::class,[
                'attr'=>['readonly'=>'readonly'],
                'class'=>Vuelo::class,
                'placeholder'=>'Seleccione vuelo',
                'choice_label'=>function($vuelo){
                    return $vuelo->getOrigen()->getNombre()."  ==>  ".$vuelo->getDestino()->getNombre();
                },
                'constraints'=>[new NotBlank()]

            ])
            ->add('avion',EntityType::class,[
                'attr'=>['readonly'=>'readonly'],
                'class'=>Avion::class,
                'placeholder'=>'Seleccione vuelo',
                'choice_label'=>function($avion){
                    return $avion->getCodigo()."  (".$avion->getMarca()->getNombre()." , ".$avion->getModelo()->getNombre().")";
                },
                'constraints'=>[new NotBlank()]
            ]);
        }else{
            $builder
                ->add('fecha',DateType::class,[
                    'format'=>'dd MM yyyy',
                    'constraints'=>[new NotBlank()]
                ])
                ->add('hora',TimeType::class,[
                    'placeholder'=>['hour'=>'Hora','minute'=>'Min'],
                    'constraints'=>[new NotBlank()]
                ])
                ->add('vuelo',EntityType::class,[
                    'class'=>Vuelo::class,
                    'placeholder'=>'Seleccione vuelo',
                    'choice_label'=>function($vuelo){
                        return $vuelo->getOrigen()->getNombre()."  ==>  ".$vuelo->getDestino()->getNombre();
                    },
                    'constraints'=>[new NotBlank()]
                ])
                ->add('avion',EntityType::class,[
                    'class'=>Avion::class,
                    'placeholder'=>'Seleccione vuelo',
                    'choice_label'=>function($avion){
                        return $avion->getCodigo()."  (".$avion->getMarca()->getNombre()." , ".$avion->getModelo()->getNombre().")";
                    },
                    'constraints'=>[new NotBlank()]
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'opt'=>'new',
            'data_class' => HorarioVuelo::class,
        ]);
    }
}
