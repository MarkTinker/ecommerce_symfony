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

class UserAddressFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'address1',
                'text',
                array(
                    'label' => 'form.address.address1',
                    'required' => false
                )
            )
            ->add(
                'address2',
                'text',
                array(
                    'label' => 'form.address.address2',
                    'required' => false
                )
            )
            ->add(
                'city',
                null,
                array(
                    'label' => 'form.address.city',
                    'required' => false
                )
            )
            ->add(
                'state',
                'choice',
                array(                    
                    'label' => 'form.address.state',
                    'choices' => array(
                        'form.address.state.NSW' => 'form.address.state.NSW',
                        'form.address.state.QLD' => 'form.address.state.QLD',
                        'form.address.state.SA' => 'form.address.state.SA',
                        'form.address.state.TAS' => 'form.address.state.TAS',
                        'form.address.state.VIC' => 'form.address.state.VIC',
                        'form.address.state.WA' => 'form.address.state.WA'
                    ),
                'required' => false,
                'choices_as_values' => true
                )
            )
            ->add(
                'postcode',
                null,
                array(
                    'label' => 'form.address.postcode',
                    'required' => false
                )
            )
            ->add(
                'country',
                'country',
                array(
                    'label' => 'form.address.country',
                    'required' => false,
                    'preferred_choices' => array("GB", "FR", "ES", "DE", "IT", "CH", "US", "RU"),
                )
            );


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Cocorico\UserBundle\Entity\UserAddress',
                'csrf_token_id' => 'user_address',
                'translation_domain' => 'cocorico_user',
                'cascade_validation' => true
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
        return 'user_address';
    }
}
