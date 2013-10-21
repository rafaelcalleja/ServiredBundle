<?php

namespace RC\ServiredBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;



class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('Ds_TransactionType')
            ->add('Ds_Card_Country')
            ->add('Ds_Date')
            ->add('Ds_SecurePayment')
            ->add('Ds_Signature')
            ->add('Ds_Order')
            ->add('Ds_Response')
            ->add('Ds_AuthorisationCode')
            ->add('Ds_Currency')
            ->add('Ds_ConsumerLanguage')
            ->add('Ds_MerchantCode')
            ->add('Ds_Amount')
            ->add('Ds_Terminal')
        ;
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));

        $resolver->setRequired(array(   	));

        $resolver->setAllowedTypes(array(
        ));

    }



    public function getName(){
        return 'transactiontype';
    }
}