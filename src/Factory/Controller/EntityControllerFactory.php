<?php

namespace CdiEntity\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiEntity\Controller;


class EntityControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

          /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("CdiDatagrid", ["customOptionsKey" => "cdiEntityEntity"]);
        
          $codeGenerator = $container->get('cdientity_generate_entity');

        $em = $container->get('Doctrine\ORM\EntityManager');
        return new Controller\EntityController($em, $grid,$codeGenerator);
    }

}
