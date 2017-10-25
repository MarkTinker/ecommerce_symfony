<?php

/**
 * This file is created by Matthieu
 * 
 * 10/24/2017 - tinkergotinker@gmail.com
 */

 namespace Cocorico\UserBundle\Form\Type;

 use Cocorico\UserBundle\Entity\User;
 use Symfony\Component\Form\AbstractType;
 use Symfony\Component\Form\FormBuilderInterface;
 use Symfony\Component\OptionsResolver\OptionsResolver;

 class UserFavoriteImageType extends AbstractType
 {
     /**
      * @param FormBuilderInterface $builder
      * @param array                $options
      */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add (
                'name',
                'hidden',
                array(
                    /** @Ignore */
                    'label' => false
                )
            )
            ->add(
                'file',
                'file',
                array(
                    'image_path' => 'webPath',
                    'imagine_filter' => 'user_small',
                    'label' => false,
                    'mapped' => false,
                    'attr' => array(
                        "class" => "dn"
                    )
                )
            )
            ->add(
                'position',
                'hidden',
                array(
                    /** @Ignore */
                    'label' => false,
                    'attr' => array(
                        "class" => "sort-position"
                    )
                )
            )
            ->add(
                'user',
                'entity_hidden',
                array(
                    'class' => 'Cocorico\UserBundle\Entity\User',
                    /** @Ignore */
                    'label' => false
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Cocorico\UserBundle\Entity\UserFavoriteImage',
                'csrf_token_id' => 'user_favorite_image',
                'translation_domain' => 'cocorico_user',
                'cascade_validation' => true,
                /** @Ignore */
                'label' => false
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
        return 'usrfavoriteimgs';
    }
 }