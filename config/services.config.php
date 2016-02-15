<?php

/**
 * User: Vladimir Garvardt
 * Date: 3/18/13
 * Time: 6:39 PM
 */
use Zend\ServiceManager\ServiceLocatorInterface;

return array(
    'invokables' => array(
         'cdientity_update_entity' => 'CdiEntity\Service\UpdateEntity',
    ),
    'factories' => array(
        'cdientity_options' => function (ServiceLocatorInterface $sm) {
            return null;
        },
    ));
        
