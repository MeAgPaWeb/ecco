<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use AppBundle\Form\Type\GenderType;
use AppBundle\Form\Type\RoleType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', PasswordType::class, array('label' => 'Contraseña'))
            ->add('plainPasswordRepeat', PasswordType::class, array('mapped' => false, 'label' => 'Repetir contraseña'))
            ->add('username', null, array('label' => 'Nombre de usuario'))
            ->add('email', null, array('label' => 'Correo electrónico'))
            ->add('name', null, array('label' => 'Nombre'))
            ->add('lastname', null, array('label' => 'Apelllido'))
            ->add('avatar', FileType::class, array('mapped' => false, 'required' => false))
            ->add('gender', GenderType::class, array(
                'label' => 'Sexo'
            ))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

}
