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
            'centity' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/centity/adm[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CdiEntity\Controller\Adm',
                        'action' => 'abm',
                    ),
                ),
            ),
            'cproperty' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cproperty/abm[/:action][/:id][/:eid][/:rid]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CdiEntity\Controller\Property',
                        'action' => 'abm',
                    ),
                ),
            ),
        ),
    ),
);


