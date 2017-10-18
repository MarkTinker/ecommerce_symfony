<?php

/**
 * Admin for Designer
 * 
 * 10/18/2017 - Mark Brandt mwbdeveloment@gmail.com
 * 
 */

 namespace Cocorico\CoreBundle\Admin;

 use Cocorico\CoreBundle\Entity\Designer;
 use Sonata\AdminBundle\Admin\Admin;
 use Sonata\AdminBundle\Datagrid\DatagridMapper;
 use Sonata\AdminBundle\Datagrid\ListMapper;
 use Sonata\AdminBundle\Form\FormMapper;
 use Sonata\AdminBundle\Form\Type\Filter\NumberType;
 use Sonata\AdminBundle\Route\RouteCollection;

 class DesignerAdmin extends Admin
 {
    protected $translationDomain = 'SonataAdminBundle';
    protected $baseRoutePattern = 'designer';
    protected $designer;

    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text');            
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        //'show' => array(),
                        'edit' => array(),
                    )
                )
            );
    }

    public function toString($object)
    {
        return $object instanceof Designer
            ? $object->getName()
            : 'Designer'; // shown in the breadcrumb on the create view
    }
 }