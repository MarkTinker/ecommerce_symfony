<?php

/**
 * This file is created by Matthieu
 * 
 * 10/26/2017 tinkergotinker@gmail.com
 */

 namespace Cocorico\CoreBundle\Admin;

 use Cocorico\CoreBundle\Entity\HomeMenu;
 use Sonata\AdminBundle\Admin\Admin;
 use Sonata\AdminBundle\Datagrid\DatagridMapper;
 use Sonata\AdminBundle\Datagrid\ListMapper;
 use Sonata\AdminBundle\Form\FormMapper;
 use Sonata\AdminBundle\Form\Type\Filter\NumberType;
 use Sonata\AdminBundle\Route\RouteCollection;

 class HomeMenuAdmin extends Admin
 {
     protected $translationDomain = "SonataAdminBundle";
     protected $baseRoutePattern = "homemenu";
     protected $locales;
     
     // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt'
    );

    public function setLocales($locales)
    {
        $this->locales = $locales;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add(
            'name',
            null,
            array(
                'label' => 'Menu Name'
            )
        )
        ->add(
            'title',
            null,
            array(
                'label' => 'Menu Title'
            )
        )
        ->add(
            'description',
            null,
            array(
                'label'=> 'Description'
            )
        )
        ->add(
            'file',
            'file',
            array(
                'required' => false
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
        )
        ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add(
            'name'
        )
        ->add(
            'title'
        )
        ->add(
            'description'
        );
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->add(
            'name'
        )
        ->add(
            'title'
        )
        ->add(
            'description',
            null,
            array('label' => 'Description')
        )
        ->add(
            'imgname',
            null,
            array('label' => 'Image Name')
        )
        ->add(
            'createdAt',
            null,
            array(
                'label' => 'admin.page.created_at.label',
                'format' => 'd/m/Y'
            )
        );

        $listMapper->add(
            '_action',
            'actions',
            array(
                'actions' => array(
//                    'create' => array(),
                    'edit' => array(),
                )
            )
        );
    }

    public function prePersist($homemenu)
    {
        $this->manageFileUpload($homemenu);
    }

    public function preUpdate($homemenu)
    {
        $this->manageFileUpload($homemenu);
    }

    private function manageFileUpload($homemenu)
    {
        if ($homemenu->getFile()) {
            $homemenu->refreshUpdated();
        }
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions["delete"]);

        return $actions;
    }

    public function toString($object)
    {
        return $object instanceof HomeMenu
            ? $object->getName()
            : ''; // shown in the breadcrumb on the create view
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        //$collection->remove('create');
        $collection->remove('delete');
    }
 }