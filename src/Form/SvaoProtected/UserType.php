<?php

namespace App\Form\SvaoProtected;

use App\Entity\Rol;
use App\Entity\SvaoProtected\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('nombre',TextType::class,[
                'attr'=>['placeholed'=>'nombre'],
                'constraints'=>[new NotBlank(),new Length(['min'=>4,'max'=>50])]
            ])
            ->add('password',PasswordType::class,[
                'attr'=>['placeholder'=>'******'],
                'constraints'=>[new NotBlank(),new Length(['min'=>4,'max'=>20])]
            ])
            ->add('rol',EntityType::class,[
                'class'=>Rol::class,
                'choice_label'=>'name',
                'constraints'=>[new NotBlank()]
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
