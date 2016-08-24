<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('firstName', 'text', array(
            'label' => 'form.firstName',
            'translation_domain' => 'FOSUser',
            'attr' => array(
                'class' => 'form-control')
        ))
            ->add('lastName', 'text', array(
                'label' => 'form.lastName',
                'translation_domain' => 'FOSUser',
                'attr' => array(
                    'class' => 'form-control')
            ))
            ->add('country', 'text', array(
                'label' => 'Country',
                'attr' => array(
                    'class' => 'form-control')
            ))
            ->add('city', 'text', array(
                'label' => 'City',
                'attr' => array(
                    'class' => 'form-control')
            ))
            ->add('plainPassword', 'password', array(
                'label' => 'Password',
                'attr' => array(
                    'class' => 'form-control')
            ))
            ->add('birthDate', 'date', array(
                'label' => 'form.dateBirth',
                'translation_domain' => 'FOSUser',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'form-control')
            ));
    }

    public function getName()
    {
        return 'app_form_registration';
    }
}
