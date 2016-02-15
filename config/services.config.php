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
            $config = $sm->get('Config');
            return new CdiEntity\Options\CdiEntityOptions(isset($config['cdientity_options']) ? $config['cdientity_options'] : array());
        },
    ));
        
