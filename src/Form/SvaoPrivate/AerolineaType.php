<?php

namespace App\Form\SvaoPrivate;

use App\Entity\SvaoPrivate\Aerolineas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AerolineaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')
            ->add('nombre')
            ->add('nombreCorto')
            ->add('nombreEncargado')
            ->add('paginaWeb')
            ->add('correo')
            ->add('fechaFundacion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Aerolinea::class,
        ]);
    }
}
