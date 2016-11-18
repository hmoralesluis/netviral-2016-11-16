<?php

namespace App\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConferenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('attr' => array('class' => 'm-wrap large')))
            ->add('author', 'text', array('attr' => array('class' => 'm-wrap large')))
            ->add('file', 'file', array('attr' => array('class' => 'm-wrap large')))
            ->add('time', null, array('attr' => array('class' => 'm-wrap large')))
            ->add('language', 'text', array('attr' => array('class' => 'm-wrap large')))
            ->add('duration', 'text', array('attr' => array('class' => 'm-wrap large')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\AdminBundle\Entity\Conference'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_adminbundle_conference';
    }
}
