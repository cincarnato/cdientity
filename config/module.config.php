<?php

return array(
    'cdientity_options' => array(
        'script_update_schema' => ''
    ),
      'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'cdientity_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/CdiEntity/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'CdiEntity\Entity' => 'cdientity_entity',
                ),
            ),
        ),
    ),
     'controllers' => array(
        'invokables' => array(
            'usersession' => 'CdiUser\Controller\UserSessionController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'cdientity' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/cdientity',
                    'defaults' => array(
                        'controller' => 'manager',
                        'action' => 'index',
                    ),
                ),
                'child_routes' => array(
                    'keepalive' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/cdientity',
                            'defaults' => array(
                                'controller' => 'manager',
                                'action' => 'keepalive',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);


