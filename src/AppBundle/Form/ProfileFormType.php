<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
//            ->add('birthDate', null, array(
//                'label' => 'Birth day'
//            ))
//            ->add('birthDate',null, array(
//                'label' => 'Birthday',
//                'attr'=> array(
//                    'class' =>'form-control'
//                )
//            ))
            ->add('birthDate','date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label'=>'Birthday',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Birthday")
            ))
            ->add('firstName','text', array(
                'label' => 'Name',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "First name")
            ))
            ->add('lastName','text', array(
                'label' => 'Last name',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Last name")
            ))
            ->add('city','text', array(
                'label' => 'City',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "City")
            ))
            ->add('country','text', array(
                'label' => 'Country',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Country")
            ))
            ->add('lng', 'choice',array(
                'label'=>'Language',
                'attr'=> array(
                    'placeholder' => "Select"),
                'choices'=>array(
                    'es'=>'ES',
                    'en'=>'EN'
                )
            ))
//            ->add('country','radio', array(
//                'label' => 'Country',
//                'attr'=> array(
//                    'class' =>'form-control',
//                    'placeholder' => "Country")
//            ))
            ->add('comments','textarea', array(
                'label' => 'About me',
                'attr'=> array(
                    'class' =>'form-control')
            ))
            ->add('picture','file', array('required'=>false))
        ;
    }

    public function getName()
    {
        return 'app_form_user_profile';
    }

}
