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
      $builder->add('use',ChoiceType::class, array(
                'label' => 'Uso de la Sala',
                'choices' => array(
                  'Depósito'  => 'Depósito',
                  'Sala de Lectura'  => 'Sala de Lectura',
                  'Mixto'  => 'Mixto',
                  )
              ))
              ->add('conditioning',ChoiceType::class, array(
                'label' => 'Equipo de Climatización',
                'choices' => array(
                  'Refrigeración'  => 'Refrigeración',
                  'Calefacción'  => 'Calefacción',
                  'Ambos'  => 'Ambos',
                  'Ninguno'  => 'Ninguno',
                  )
              ))
              ->add('exposedFaces',ChoiceType::class, array(
                'label' => 'Seleccione las caras expuestas al exterior (considere el piso y el techo)',
                'choices' => array(
                  '0'  => '0',
                  '1'  => '1',
                  '2'  => '2',
                  '3'  => '3',
                  '4'  => '4',
                  '5'  => '5',
                  '6'  => '6',
                  )
              ))
              ->add('width',null, array(
                'label' => 'Ancho',
                'attr' => array(
                  'placeholder'  => 'Ingrese el ancho')
              ))
              ->add('length',null, array(
                'label' => 'Largo',
                'attr' => array(
                  'placeholder'  => 'Ingrese el largo')
              ))
              ->add('high',null, array(
                'label' => 'Alto',
                'attr' => array(
                  'placeholder'  => 'Ingrese el alto')
              ))
              ->add('roofComposition',ChoiceType::class, array(
                'label' => 'Composición del Techo',
                'choices' => array(
                  'Cubierta hormigón armado'  => 'Cubierta hormigón armado',
                  'Entrepiso hormigón armado'  => 'Entrepiso hormigón armado',
                  'Entrepiso madera'  => 'Entrepiso madera',
                  'Cubierta de chapa'  => 'Cubierta de chapa',
                  'Cubierta de tejas'  => 'Cubierta de tejas',
                  )
              ))
              ->add('floorComposition',ChoiceType::class, array(
                'label' => 'Composición del Piso',
                'choices' => array(
                  'Entrepiso madera'  => 'Entrepiso madera',
                  'Entrepiso hormigón armado'  => 'Entrepiso hormigón armado',
                  'Terreno natural'  => 'Terreno natural',
                  )
              ))
              ->add('wallComposition',ChoiceType::class, array(
                'label' => 'Composición de las paredes',
                'choices' => array(
                  'Rev + Lad. hueco + Rev'  => 'Rev + Lad. hueco + Rev',
                  'Rev + Lad.20 cm + Rev'  => 'Rev + Lad.20 cm + Rev',
                  'Rev + Lad. 25 + Rev'  => 'Rev + Lad. 25 + Rev',
                  'Rev + Lad. común 30 cm + Rev'  => 'Rev + Lad. común 30 cm + Rev',
                  'Rev + Lad. común 45 cm + Rev'  => 'Rev + Lad. común 45 cm + Rev',
                  )
              ))
              ->add('windowComposition',ChoiceType::class, array(
                'label' => 'Composición de las ventanas',
                'choices' => array(
                  'de hierro o chapa vidrio simple'  => 'de hierro o chapa vidrio simple',
                  'de madera vidrio simple'  => 'de madera vidrio simple',
                  'de aluminio vidrio simple'  => 'de aluminio vidrio simple',
                  'de aluminio c/ vidrio doble'  => 'de aluminio c/ vidrio doble',
                  'de PVC con vidrio simple'  => 'de PVC con vidrio simple',
                  'de PVC con vidrio doble'  => 'de PVC con vidrio doble',
                  )
              ))
              ->add('glazedSurface',null, array(
                'label' => 'Superficie Total Vidriada',
                'attr' => array(
                  'placeholder'  => 'Ingrese la superficie vidriada')
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
