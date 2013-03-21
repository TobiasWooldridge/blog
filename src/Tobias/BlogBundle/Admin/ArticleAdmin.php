<?php
namespace Tobias\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ArticleAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('summary', null, $options = array('attr' => array('rows' => 15)))
            ->add('content', null, $options = array('attr' => array('rows' => 30)))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('slug')
            ->add('title')
            ->add('created')
            ->add('createdBy')
            ->add('updated')
            ->add('updatedBy')
        ;
    }
}
