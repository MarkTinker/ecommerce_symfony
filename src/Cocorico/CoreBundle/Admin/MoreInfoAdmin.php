<?php

/**
 * Admin for MoreInfo Section
 * 
 * 10/20/2017 - Matthieu Baillieu tinkergotinker@gmail.com 
 * 
 */

 namespace Cocorico\CoreBundle\Admin;

 use Cocorico\CoreBundle\Entity\MoreInfo;
 use Sonata\AdminBundle\Admin\Admin;
 use Sonata\AdminBundle\Datagrid\DatagridMapper;
 use Sonata\AdminBundle\Datagrid\ListMapper;
 use Sonata\AdminBundle\Form\FormMapper;
 use Sonata\AdminBundle\Form\Type\Filter\NumberType;
 use Sonata\AdminBundle\Route\RouteCollection;

 class MoreInfoAdmin extends Admin
 {
    protected $translationDomain = 'SonataAdminBundle';
    protected $baseRoutePattern = 'moreinfo';
    protected $moreinfo;

    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'url'
            )
            ->add(
                'title'
            )
            ->add(
                'description'
            )
            ->add(
                'published', 
                null,
                array(
                    'label' => 'admin.page.published.label'
                )
            )
            ->add(
                'createdAt',
                null,
                array(
                    'disabled' => true,
                    'label' => 'admin.page.created_at.label'
                )
            )
            ->add(
                'updatedAt',
                null,
                array(
                    'disabled' => true,
                    'label' => 'admin.page.updated_at.label'
                )
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')        
            ->add('url')
            ->add('description')
            ->add('published')
            ->add(
                'createdAt',
                null,
                array(
                    'label' => 'admin.page.created_at.label',
                    'format' => 'd/m/Y'
                )
            )
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        //'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
                )
            );
    }

    public function toString($object)
    {
        return $object instanceof MoreInfo
            ? $object->getTitle()
            : ''; // shown in the breadcrumb on the create view
    }

 }