<?php

/**
 * This file is created by Matthieu
 * 
 * 10/23/2017 tinkergotinker@gmail.com
 */

 namespace Cocorico\CoreBundle\Admin;

 use Cocorico\CoreBundle\Entity\ListingHowtoWear;
 use Cocorico\CoreBundle\Entity\Listing;
 use Doctrine\ORM\Query\Expr;
 use Sonata\AdminBundle\Admin\Admin;
 use Sonata\AdminBundle\Datagrid\DatagridMapper;
 use Sonata\AdminBundle\Datagrid\ListMapper;
 use Sonata\AdminBundle\Form\FormMapper;
 use Sonata\AdminBundle\Form\Type\Filter\NumberType;
 use Sonata\AdminBundle\Route\RouteCollection;

 class ListingHowtoWearAdmin extends Admin
 {
    protected $translationDomain = 'SonataAdminBundle';
    protected $baseRoutePattern = 'howtowear';
    protected $listinghowtowear;

    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'listing_id1'
            )
            ->add(
                'listing_id2'
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'listing_id1'
            );
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->add('listing_id1')        
        ->add('listing_id2')
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
            ? $object->getId()
            : ''; // shown in the breadcrumb on the create view
    }
 }