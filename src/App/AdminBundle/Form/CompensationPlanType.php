<?php

namespace App\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompensationPlanType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('attr' => array('class' => 'm-wrap large')))
            ->add('description', 'textarea', array('attr' => array('class' => 'm-wrap large')))
            ->add('percentage', 'integer', array('attr' => array('class' => 'm-wrap large')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\AdminBundle\Entity\CompensationPlan'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_adminbundle_compensationplan';
    }
}
