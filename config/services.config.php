<?php

/**
 * User: Cristian Incarnato
 */
use Zend\ServiceManager\ServiceLocatorInterface;

return array(
    'invokables' => array(
    ),
    'factories' => array(
        'cdientity_options' => function (ServiceLocatorInterface $sm) {
            $config = $sm->get('Config');
            return new \CdiEntity\Options\CdiEntityOptions(isset($config['cdientity_options']) ? $config['cdientity_options'] : array());
        },
                'cdientity_update_entity' => function (ServiceLocatorInterface $sm) {
            $service = new \CdiEntity\Service\UpdateEntity();
            $service->setServiceManager($sm);
            return $service;
        },
                'cdientity_generate_entity' => function (ServiceLocatorInterface $sm) {
            $service = new \CdiEntity\Service\CodeGenerator();
            $service->setServiceManager($sm);
            return $service;
        }
        ));
        
