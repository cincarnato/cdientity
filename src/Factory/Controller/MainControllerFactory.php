<?php

namespace CdiEntity\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiEntity\Controller;
use CdiDataGrid\Source\Doctrine\DoctrineSource;

class MainControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        $id = $container->get('Application')->getMvcEvent()->getRouteMatch()->getParam('id', false);

        $em = $container->get('Doctrine\ORM\EntityManager');

        $query = $em->createQueryBuilder()
                ->select('u')
                ->from('CdiEntity\Entity\Entity', 'u')
                ->where("u.id = :id")
                ->setParameter("id", $id);
        $entity = $query->getQuery()->getOneOrNullResult();

        $gridconfig = "cdigrid_" . $entity->getNamespace()->getName() . "_" . $entity->getName();
    
        /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("CdiDatagrid", ["customOptionsKey" => $gridconfig]);

        //ColumnConfig
        $gridConfig = $container->get('config')[$gridconfig];

        return new Controller\MainController($em, $grid, $entity, $gridConfig);
    }

}
