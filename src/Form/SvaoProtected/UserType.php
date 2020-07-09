<?php

namespace App\Form\SvaoProtected;

use App\Entity\Rol;
use App\Entity\SvaoPrivate\Aerolinea;
use App\Entity\SvaoPrivate\Aeropuerto;
use App\Entity\SvaoProtected\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,[
                'attr'=>['placeholed'=>'username'],
                'constraints'=>[new NotBlank(),new Length(['min'=>4,'max'=>50])]
            ])
            ->add('password',PasswordType::class,[
                'attr'=>['placeholder'=>'* * * * * *'],
                'constraints'=>[new NotBlank(),new Length(['min'=>4,'max'=>20])]
            ])
            ->add('rol',EntityType::class,[
                'class'=>Rol::class,
                'choice_label'=>'name',
                'constraints'=>[new NotBlank()]
            ])
            ->add('aerolinea',EntityType::class,
                [
                    'class'=>Aerolinea::class,
                    'placeholder'=>'Seleccione aerolinea',
                    'choice_label'=>'nombre'
                ])
            ->add('aeropuerto',EntityType::class,
                [
                    'class'=>Aeropuerto::class,
                    'placeholder'=>'Seleccione Aeropuerto',
                    'choice_label'=>'nombre'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
