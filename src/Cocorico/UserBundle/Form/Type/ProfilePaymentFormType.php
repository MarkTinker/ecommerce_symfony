<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilePaymentFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'lastName',
                'text',
                array(
                    'label' => 'form.user.last_name',
                )
            )
            ->add(
                'firstName',
                'text',
                array(
                    'label' => 'form.user.first_name'
                )
            )
            ->add(
                'birthday',
                'birthday',
                array(
                    'label' => 'form.user.birthday',
//                    'format' => 'dd MMMM yyyy',
                    'widget' => "choice",
                    'years' => range(date('Y') - 18, date('Y') - 100),
                    'required' => true
                )
            )
            ->add(
                'bankAccountName',
                null,
                array(
                    'label' => 'form.user.bank_account_name',
                    'required' => true,
//                    'disabled' => $bankEditionDisabled
                )
            )
            ->add(
                'bsb',
                'text',
                array(
                    'label' => 'form.user.bsb',
                    'required' => true
                )
            )
            ->add(
                'account',
                'text',
                array(
                    'label' => 'form.user.account',
                    'required' => true
                )
            );


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Cocorico\UserBundle\Entity\User',
                'csrf_token_id' => 'CocoricoProfilePayment',
                'translation_domain' => 'cocorico_user',
                'cascade_validation' => true,
                'validation_groups' => array('CocoricoProfilePayment'),
            )
        );
    }

    /**
     * BC
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'user_profile_payment';
    }
}
