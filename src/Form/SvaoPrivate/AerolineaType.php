<?php

namespace App\Form\SvaoPrivate;

use App\Entity\SvaoPrivate\Aerolinea;
use App\Entity\SvaoPrivate\Pais;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AerolineaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo',TextType::class,['attr'=>['placeholder'=>'codigo'],
                'constraints'=>[new Length(['min'=>2,'max'=>6]),new NotBlank()]
            ])
            ->add('nombre',TextType::class,['attr'=>['placeholder'=>'nombre oficial'],
                'constraints'=>[new Length(['min'=>3,'max'=>100]),new NotBlank()]
                ])
            ->add('nombreCorto',TextType::class,['attr'=>['placeholder'=>'nombre corto'],
                'constraints'=>[new Length(['min'=>2,'max'=>50]), new NotBlank()]
            ])
            ->add('nombreEncargado',TextType::class,['attr'=>['placeholder'=>'encargado'],
                'constraints'=>[new NotBlank(),new Length(['min'=>6,'max'=>100])]
            ])
            ->add('paginaWeb',UrlType::class,['attr'=>['placeholder'=>'https://debia.art.com'],
                'constraints'=>[new NotBlank()]
                ])
            ->add('correo',EmailType::class,['attr'=>['placeholder'=>'bad115@gmail.com'],
                'constraints'=>[new NotBlank()]])
            ->add('fechaFundacion',DateType::class,['attr'=>['placeholder'=>'dd/mm/yyyy'],
                'constraints'=>[new NotBlank()]])
            ->add('pais',EntityType::class,[
                        'class'=>Pais::class,
                        'placeholder'=>'Seleccione pais',
                        'choice_label'=>'nombre',
                        'constraints'=>[new NotBlank()]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Aerolinea::class,
        ]);
    }
}
