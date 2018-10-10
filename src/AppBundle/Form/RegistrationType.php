<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Form\Type\RoleType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
                    'label' => 'Nombre'));
        $builder->add('lastname', TextType::class, array(
                    'label' => 'Apellido'));
        $builder->add('avatar', FileType::class, array('mapped' => false, 'required' => false));
        if ($options["edit_roles"]){
            $builder->add('roles', RoleType::class, array(
                'label' => 'Rol',
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
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
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
            'edit_roles' => false
        ));
    }
}
?>
