<?php

namespace CdiEntity\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class NamespacesControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

       
        /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("CdiDatagridDoctrine", ["customOptionsKey" => "cdiEntityNamespace"]);
      
        
        $em = $container->get('doctrine.entitymanager.orm_cdientity');
        return new \CdiEntity\Controller\NamespacesController($em, $grid);
    }

}
