<?php

namespace CdiEntity\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiEntity\Controller;
use CdiDataGrid\Source\Doctrine\DoctrineSource;

class MainControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

       
        /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("CdiDatagrid");
      
        
        $em = $container->get('Doctrine\ORM\EntityManager');
        return new Controller\MainController($em, $grid);
    }

}
