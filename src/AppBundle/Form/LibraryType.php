<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LibraryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',null, array(
                'label' => 'Nombre',
                'attr' => array(
                  'placeholder'  => 'Nombre de la Biblioteca, Dependencia')
                ))
                ->add('address',null,array(
                  'label' => 'Dirección',
                  'attr' => array(
                    'placeholder'  => 'Calle, Número, Ciudad, Provincia, País')
                ))
                ->add('age',TextType::class,array(
                  'label' => 'Año de Edificación',
                  'attr' => array(
                    'placeholder'  => 'yyyy')
                ))
                ->add('position',HiddenType::class,array())
                ->add('colour',null,array(
                  'label' => 'Color de Identificación',
                  'attr' => array(
                    'placeholder'  => '#00000',
                    'empty_data'  => '#22c0dd',
                    'class' => 'form-control my-colorpicker1 colorpicker-element')
                ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Library'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_library';
    }


}
