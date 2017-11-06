<?php

/**
 * Admin for EditorPick
 * 
 * This file is created by Matthieu Baillieu
 * 
 * 11/04/2017 - tinkergotinker@gmail.com
 */
namespace Cocorico\CoreBundle\Admin;

use Cocorico\CoreBundle\Entity\EditorPick;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\NumberType;
use Sonata\AdminBundle\Route\RouteCollection;

class EditorPickAdmin extends Admin
{
    protected $translationDomain = 'SonataAdminBundle';
    protected $baseRoutePattern = 'editorpick';
    protected $editorpick;

    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt'
    );

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('listing');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('listing');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('listing.name')
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
        ;
    }

    public function toString($object)
    {
        return $object instanceof EditorPick
            ? $object->getListing()
            : 'EditorPick'; // shown in the breadcrumb on the create view
    }
}