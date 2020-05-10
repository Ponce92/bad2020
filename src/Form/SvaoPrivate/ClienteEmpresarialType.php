<?php

namespace App\Form\SvaoPrivate;

use App\Entity\SvaoPrivate\Cliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClienteEmpresarialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombres',TextType::class,['attr'=>['placeholder'=>'nombre'],
                'required'=>true,
                'constraints'=>[new Length(['min'=>6,'max'=>50])]
            ])
            ->add('direccion',TextType::class,['attr'=>['placeholder'=>'direccion'],
                'required'=>true,
                'constraints'=>[new Length(['min'=>6,'max'=>50]), new NotBlank()]
            ])
            ->add('fijo',NumberType::class,['attr'=>['placeholder'=>'tel.'],
                'required'=>true,
                'constraints'=>[new Length(['min'=>8,'max'=>8])]
            ])
            ->add('movil',NumberType::class,['attr'=>['placeholder'=>'movil.'],
                'constraints'=>[new Length(['min'=>8,'max'=>8])]
            ])

            ->add('encargado',TextType::class,['attr'=>['placeholder'=>'nombre encargado'],
                'required'=>true,
                'constraints'=>[new NotBlank(),new Length(['min'=>6,'max'=>50])]
            ])
            ->add('nit',TextType::class,['attr'=>['placeholder'=>'####-######-###-#'],
                'required'=>true,
                'constraints'=>[new Length(['min'=>4,'max'=>12]), new NotBlank()]
            ])
            ->add('nic',TextType::class,['attr'=>['placeholder'=>'####-######-###-#'],
                'required'=>true,
                'constraints'=>[new Length(['min'=>2,'max'=>12]),new NotBlank()]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cliente::class,
        ]);
    }
}
