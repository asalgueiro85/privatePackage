<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('facebookID')
//            ->add('googleID')
//            ->add('pathPicture')

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
//            ->add('city','text', array(
//                'label' => 'City',
//                'attr'=> array(
//                    'class' =>'form-control',
//                    'placeholder' => "City")
//            ))
//            ->add('country','text', array(
//                'label' => 'Country',
//                'attr'=> array(
//                    'class' =>'form-control',
//                    'placeholder' => "Country")
//            ))
            ->add('state','text', array(
                'label' => 'State',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "State")
            ))
            ->add('lng', 'choice',array(
                'label'=>'Language',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Select"),
                'choices'=>array(
                    'es'=>'ES',
                    'en'=>'EN'
                )
            ))
//            ->add('sex','radio')
            ->add('comments','textarea', array(
                'label' => 'About me',
                'attr'=> array(
                    'class' =>'form-control')
            ))
            ->add('picture','file', array('required'=>false))
//            ->add('pathPicture')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_user';
    }
}
