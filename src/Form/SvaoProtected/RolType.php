<?php

namespace App\Form\SvaoProtected;

use App\Entity\Rol;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',
                NumberType::class,
                [
                    'attr'=>['hidden'=>'hidden'],
                    'required'=>false,

                ])
            ->add('name',
                   TextType::class,
                        [
                        'attr'=>['placeholder'=>'Rol'
                                ],
                        'required'=>false,
                        ])
            ->add('description',TextareaType::class,
                                        [
                                        'attr'=>['placeholder'      =>'Descripcion del rol',
                                                 'rows'             =>3,
                                                ],
                                        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rol::class,
        ]);
    }
}
