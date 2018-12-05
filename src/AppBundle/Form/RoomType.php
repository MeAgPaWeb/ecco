<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use AppBundle\Entity\Library;

class RoomType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->add('name',null, array(
                    'label' => 'Nombre de la sala',
                    'attr' => array(
                      'placeholder'  => 'Ingrese el nombre de la sala')
                  ))
              ->add('use',ChoiceType::class, array(
                'label' => 'Uso de la Sala',
                'placeholder'  => true,
                'choices' => array(
                  'Depósito'  => 'Depósito',
                  'Sala de Lectura'  => 'Sala de Lectura',
                  'Mixto'  => 'Mixto',
                ),
                'attr' => array(
                  'class'  => 'select2')
              ))
              ->add('conditioning',ChoiceType::class, array(
                'label' => 'Equipo de Climatización',
                'placeholder'  => true,
                'choices' => array(
                  'Refrigeración'  => 'Refrigeración',
                  'Calefacción'  => 'Calefacción',
                  'Ambos'  => 'Ambos',
                  'Ninguno'  => 'Ninguno',
                  ),
                  'attr' => array(
                    'class'  => 'select2')
              ))
              ->add('exposedFaces',ChoiceType::class, array(
                'label' => 'Seleccione las caras expuestas al exterior (considere el piso y el techo)',
                'placeholder'  => true,
                'choices' => array(
                  '0'  => '0',
                  '1'  => '1',
                  '2'  => '2',
                  '3'  => '3',
                  '4'  => '4',
                  '5'  => '5',
                  '6'  => '6',
                  ),
                  'attr' => array(
                    'class'  => 'select2')
              ))
              ->add('width',null, array(
                'label' => 'Ancho (metros)',
                'attr' => array(
                  'placeholder'  => 'Ingrese el valor en metros')
              ))
              ->add('length',null, array(
                'label' => 'Largo (metros)',
                'attr' => array(
                  'placeholder'  => 'Ingrese el valor en metros')
              ))
              ->add('high',null, array(
                'label' => 'Alto (metros)',
                'attr' => array(
                  'placeholder'  => 'Ingrese el alto')
              ))
              ->add('roofComposition',ChoiceType::class, array(
                'label' => 'Composición del Techo',
                'placeholder'  => true,
                'choices' => array(
                  'Cubierta hormigón armado'  => 'Cubierta hormigón armado',
                  'Entrepiso hormigón armado'  => 'Entrepiso hormigón armado',
                  'Entrepiso madera'  => 'Entrepiso madera',
                  'Cubierta de chapa'  => 'Cubierta de chapa',
                  'Cubierta de tejas'  => 'Cubierta de tejas',
                  ),
                  'attr' => array(
                    'class'  => 'select2')
              ))
              ->add('floorComposition',ChoiceType::class, array(
                'label' => 'Composición del Piso',
                'placeholder'  => true,
                'choices' => array(
                  'Entrepiso madera'  => 'Entrepiso madera',
                  'Entrepiso hormigón armado'  => 'Entrepiso hormigón armado',
                  'Terreno natural'  => 'Terreno natural',
                  ),
                  'attr' => array(
                    'class'  => 'select2')
              ))
              ->add('wallComposition',ChoiceType::class, array(
                'label' => 'Composición de las paredes',
                'placeholder'  => true,
                'choices' => array(
                  'Rev + Lad. hueco + Rev'  => 'Rev + Lad. hueco + Rev',
                  'Rev + Lad.20 cm + Rev'  => 'Rev + Lad.20 cm + Rev',
                  'Rev + Lad. 25 + Rev'  => 'Rev + Lad. 25 + Rev',
                  'Rev + Lad. común 30 cm + Rev'  => 'Rev + Lad. común 30 cm + Rev',
                  'Rev + Lad. común 45 cm + Rev'  => 'Rev + Lad. común 45 cm + Rev',
                  ),
                  'attr' => array(
                    'class'  => 'select2')
              ))
              ->add('windowComposition',ChoiceType::class, array(
                'label' => 'Composición de las ventanas',
                'placeholder'  => true,
                'choices' => array(
                  'de hierro o chapa vidrio simple'  => 'de hierro o chapa vidrio simple',
                  'de madera vidrio simple'  => 'de madera vidrio simple',
                  'de aluminio vidrio simple'  => 'de aluminio vidrio simple',
                  'de aluminio c/ vidrio doble'  => 'de aluminio c/ vidrio doble',
                  'de PVC con vidrio simple'  => 'de PVC con vidrio simple',
                  'de PVC con vidrio doble'  => 'de PVC con vidrio doble',
                  ),
                  'attr' => array(
                    'class'  => 'select2')
              ))
              ->add('glazedSurface',null, array(
                'label' => 'Superficie Total Vidriada (m2)',
                'attr' => array(
                  'placeholder'  => 'Ingrese el valor en m2')
              ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Room'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_room';
    }


}
