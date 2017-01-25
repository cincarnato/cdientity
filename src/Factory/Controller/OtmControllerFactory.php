<?php

namespace CdiEntity\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiEntity\Controller;
use CdiDataGrid\Source\Doctrine\DoctrineSource;

class OtmControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        $entityId = $container->get('Application')->getMvcEvent()->getRouteMatch()->getParam('entityId', false);

        $em = $container->get('Doctrine\ORM\EntityManager');

        $emCdiEntity = $container->get('doctrine.entitymanager.orm_cdientity');

        $query = $emCdiEntity->createQueryBuilder()
                ->select('u')
                ->from('CdiEntity\Entity\Entity', 'u')
                ->where("u.id = :id")
                ->setParameter("id", $entityId);
        $entity = $query->getQuery()->getOneOrNullResult();

        $entityName = $entity->getNamespace()->getName() . "\Entity\\" . $entity->getName();

        $gridconfig = "cdigrid_" . $entity->getNamespace()->getName() . "_" . $entity->getName();

        /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("CdiDatagrid", ["customOptionsKey" => $gridconfig]);

        return new Controller\OtmController($em, $emCdiEntity, $grid, $entity);
    }

}
