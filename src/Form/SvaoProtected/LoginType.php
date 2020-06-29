<?php

namespace App\Form\SvaoProtected;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints\NotBlank;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,['attr'=>['placeholder'=>'usuario'],
                'required'=>true,
                'constraints'=>[new NotBlank()]
            ])
            ->add('password',PasswordType::class,['attr'=>['placeholder'=>'**********'],
                'required'=>true,
                'constraints'=>[new NotBlank()]
                ])
            ->add('Login', SubmitType::class, [
                'attr' => ['class' => 'btn btn-info btn-lg btn-block'],
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
