<?php

namespace CdiEntity\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiEntity\Controller;
use CdiDataGrid\Source\Doctrine\DoctrineSource;

class EditorControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        $id = $container->get('Application')->getMvcEvent()->getRouteMatch()->getParam('entityId', false);

        $em = $container->get('Doctrine\ORM\EntityManager');

        $query = $em->createQueryBuilder()
                ->select('u')
                ->from('CdiEntity\Entity\Entity', 'u')
                ->where("u.id = :id")
                ->setParameter("id", $id);
        $entity = $query->getQuery()->getOneOrNullResult();
   
        $entityName = $entity->getNamespace()->getName()."\Entity\\".$entity->getName();
        
        /* @var $editor \CdiEntity\Service\Editor */
       $editor = $container->get('cdientity_editor');
       $editor->setEntityName($entityName);

        return new Controller\EditorController($em, $editor,$entity);
    }

}
