<?php

namespace CdiNamespace\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiEntity\Controller;

class TemplateControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {
        /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("CdiDatagrid", ["customOptionsKey" => "cdiEntityTemplate"]);
        /* @var $em Doctrine\ORM\EntityManager */
        $em = $container->get('Doctrine\ORM\EntityManager');
        return new Controller\EntityController($em, $grid);
    }

}
