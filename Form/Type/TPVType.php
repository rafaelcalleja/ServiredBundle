<?php

namespace RC\ServiredBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class TPVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('Ds_Merchant_Amount')
            ->add('Ds_Merchant_Currency')
            ->add('Ds_Merchant_Order')
            ->add('Ds_Merchant_MerchantCode')
            ->add('Ds_Merchant_Terminal')
            ->add('Ds_Merchant_TransactionType')
            ->add('Ds_Merchant_MerchantURL')
            ->add('Ds_Merchant_MerchantSignature')
        ;
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults(array(
        ));

        $resolver->setRequired(array(   	));

        $resolver->setAllowedTypes(array(
        ));

    }



    public function getName(){
        return 'tpvtype';
    }
}