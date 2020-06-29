<?php

namespace App\Form\SvaoPrivate;

use App\Entity\SvaoPrivate\Cliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClienteNaturalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombres',TextType::class,['attr'=>['placeholder'=>'nombre'],
                                                        'constraints'=>[new NotBlank(),new Length(['min'=>4,'max'=>50])]
                                                        ])
            ->add('apellidos',TextType::class,['attr'=>['placeholder'=>'apellidos'],
                                                        'constraints'=>[new Length(['min'=>6,'max'=>50]),new NotBlank()]
                                                        ])
            ->add('movil',NumberType::class,['attr'=>['placeholder'=>'tel.'],
                                                        'required'=>true,
                                                        'constraints'=>[new Length(['min'=>8,'max'=>8]),new NotBlank()]
                                                        ])
            ->add('tipoDoc',ChoiceType::class,['choices'=>['Seleccione tipo'=>null,
                                                                      'DUI'=>'dui',
                                                                      'NIT'=>'nit'
                                                                    ],
                                                          'required'=>true,
                                                          'constraints'=>[new NotBlank()]
                                                          ])
            ->add('fechaNacimiento',DateType::class, [
                    'attr'=>['placeholder'=>'date'],
                    'constraints'=>[new NotBlank()]
                    ])

            ->add('documento',TextType::class,['attr'=>['placeholder'=>'ingrese valor'],
                'required'=>true,
            ])

            ->add('genero',ChoiceType::class,[
                        'choices'=>[
                                    'Masculino'=>0,
                                    'Femenino'=>1,
                                    ],
                        'expanded'=>true,
                        'multiple'=>false,
                        'constraints'=>[new NotBlank()]
                ])
            ->add('direccion',TextType::class,['attr'=>['placeholder'=>'direccion'],
                'required'=>true,
                'constraints'=>[new Length(['min'=>6,'max'=>50]), new NotBlank()]
            ])
            ->add('email',EmailType::class,['attr'=>['placeholder'=>'ues@edu.sv'],
                'required'=>true,
                'constraints'=>[new Length(['min'=>6,'max'=>50]), new NotBlank()],
                'mapped'=>false
            ])
            ->add('password',PasswordType::class,['attr'=>['placeholder'=>'pppppppp'],
                'required'=>true,
                'mapped'=>false,
                'constraints'=>[new Length(['min'=>6,'max'=>50]), new NotBlank()]
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
