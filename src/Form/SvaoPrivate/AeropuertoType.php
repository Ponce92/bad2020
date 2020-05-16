<?php

namespace App\Form\SvaoPrivate;


use App\Entity\SvaoPrivate\Aeropuerto;
use App\Entity\SvaoPrivate\Ciudad;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class AeropuertoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo',TextType::class,['attr'=>['placeholder'=>'codigo'],
                        'constraints'=>[new NotBlank(),new Length(['min'=>6,'max'=>6])]
                        ])
            ->add('nombre',TextType::class,['attr'=>['placeholder'=>'aeropuerto'],
                'constraints'=>[new NotBlank(),new Length(['min'=>4])]])
            ->add('telefono', NumberType::class,['attr'=>['placeholder'=>'0000 0000'],
                'constraints'=>[new NotBlank(),new Length(['min'=>8,'max'=>8])]])
            ->add('encargado',TextType::class,['attr'=>['placeholder'=>'Nombre encargado'],
                'constraints'=>[new NotBlank(),new Length(['min'=>4,'max'=>50])]])
            ->add('bahias',NumberType::class,['constraints'=>[new NotBlank()]])
            ->add('ciudad',EntityType::class,[
                'class'=>Ciudad::class,
                'choice_label'=>'nombre',
                'constraints'=>[new NotBlank()]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Aeropuerto::class,
        ]);
    }
}
