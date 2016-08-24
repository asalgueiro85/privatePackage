<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFrom','date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label'=>'Date from',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Date from",
                    'ng-disabled' => 'packet')
            ))
            ->add('dateTo','date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label'=>'Date to',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Date to",
                    'ng-disabled' => 'packet')
            ))
            ->add('price',null, array(
                'label'=>'Price',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Precio",
                    'ng-disabled' => 'packet')
            ))
            ->add('weight',null, array(
                'label'=>'Weight',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Weight",
                    'ng-disabled' => 'packet')
            ))
            ->add('volumen',null, array(
                'label'=>'Volume',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Volumen",
                    'ng-disabled' => 'packet')
            ))
            ->add('volumen', 'choice',array(
                'label'=>'Volume',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Select"),
                'choices'=>array(
                    'xsmall'=>'40cm x 40cm',
                    'small'=>'50cm x 50cm',
                    'large'=>'60cm x 60cm',
                    'xlarge'=>'70cm x 70cm'
                )
            ))
            ->add('caridad','checkbox', array(
                'label'=>'Charity',
                'required'=>false,
                'attr'=> array(
                    'class' =>'ios-switch-old',
                    'ng-disabled' => 'packet')
            ))
            ->add('carryType','text', array(
                'required'=>false,
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Car type",
                    'ng-disabled' => 'packet')
            ))
            ->add('packetName','text', array(
                'label' => 'Packet tile',
                'required'=>false,
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Packet",
                    'ng-disabled' => 'packet')
            ))
            ->add('observation','textarea', array(
                'label' => 'Description',
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Max 120 characters...",
                    'ng-disabled' => 'packet')
            ))
            ->add('picture','file', array(
                'required'=>false,
                'attr'=> array(
                    'class' =>'form-control',
                    'ng-disabled' => 'packet')
            ))
//            ->add('pathPicture')
            ->add('coordenateFrom',null, array(
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Coordenate from")
            ))
            ->add('coordenateTo',null, array(
                'attr'=> array(
                    'class' =>'form-control',
                    'placeholder' => "Coordenate to")
            ))
            ->add('direction', new DirectionType(), array(

                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('carry')
//            ->add('user')
//            ->add('state')
//            ->add('type')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Action'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_action';
    }
}
