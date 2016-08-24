<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DirectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('countryFrom','text', array(
//                'attr'=> array(
//                    'class' =>'form-control',
//                    'placeholder' => "Country")
//            ))
//            ->add('cityFrom','text', array(
//                'attr'=> array(
//                    'class' =>'form-control',
//                    'placeholder' => "City")
//            ))
//            ->add('stateFrom','text', array(
//                'attr'=> array(
//                    'class' =>'form-control',
//                    'placeholder' => "State/Province")
//            ))
            ->add('zipCodeFrom', 'text', array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => "Zip Code",
                    'ng-disabled' => 'location')
            ))
            ->add('numberFrom', 'text', array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => "Number",
                    'ng-disabled' => 'location')
            ))
            ->add('floorFrom', 'text', array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => "Floor",
                    'ng-disabled' => 'location')
            ))
//            ->add('countryTo','text', array(
//                'attr'=> array(
//                    'class' =>'form-control',
//                    'placeholder' => "Country")
//            ))
//            ->add('cityTo','text', array(
//                'attr'=> array(
//                    'class' =>'form-control',
//                    'placeholder' => "City")
//            ))
//            ->add('stateTo','text', array(
//                'attr'=> array(
//                    'class' =>'form-control',
//                    'placeholder' => "State/Province")
//            ))
            ->add('zipCodeTo', 'text', array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => "Zip Code",
                    'ng-disabled' => 'location')
            ))
            ->add('numberTo', 'text', array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => "Number",
                    'ng-disabled' => 'location')
            ))
            ->add('floorTo', 'text', array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => "Floor",
                    'ng-disabled' => 'location')
            ))
            ->add('action');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Direction'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_direction';
    }
}
