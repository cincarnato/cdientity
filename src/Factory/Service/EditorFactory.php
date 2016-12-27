<?php

namespace CdiEntity\Factory\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiEntity\Service\Editor;

class EditorFactory implements FactoryInterface {

    protected $container;


    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {
        $this->container = $container;


        /* @var $application \Zend\Mvc\Application */
        $application = $container->get('application');

        /* @var $mvcevent \Zend\Mvc\MvcEvent */
        $mvcevent = $application->getMvcEvent();
        
        
        /* @var $mvcevent \Doctrine\ORM\EntityManager */
        $em = $this->container->get('Doctrine\ORM\EntityManager');
        
        
        $editor = new Editor($mvcevent, $em);
        
        return $editor;
    }
    
}
