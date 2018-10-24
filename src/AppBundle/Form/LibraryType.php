<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

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
                ->add('age',null,array(
                  'label' => 'Año de Edificación',
                  'attr' => array(
                    'placeholder'  => 'yyyy')
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
