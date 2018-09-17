<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use AppBundle\Form\Type\RoleType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array('label' => 'Nombre'));
        $builder->add('lastname', null, array('label' => 'Apellido'));
        $builder->add('avatar', FileType::class, array('mapped' => false, 'required' => false));
        $builder->add('gender', GenderType::class, array(
                'label' => 'Sexo'
            ));
        if (!$options["profile"]){
            $builder->add('roles', RoleType::class, array(
                'label' => 'Roles',
                'required' => true,
                'multiple' => true,
                'mapped' => true,
            ));
            //not require type current password of a User to can Admin edit him...
            $builder->remove('current_password');
        }
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'profile' => true
        ));
    }
}
?>
