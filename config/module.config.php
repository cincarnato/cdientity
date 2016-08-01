<?php

return array(
    'cdientity_options' => array(
        'script_update_schema' => '',
        'autoupdate' => false
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
            'CdiEntity\Controller\Namespaces' => 'CdiEntity\Controller\NamespacesController',
            'CdiEntity\Controller\Entity' => 'CdiEntity\Controller\EntityController',
            'CdiEntity\Controller\Property' => 'CdiEntity\Controller\PropertyController',
            'CdiEntity\Controller\Main' => 'CdiEntity\Controller\MainController',
        ),
    ),
      'view_helpers' => array(
        'invokables' => array(
            'CustomEntityLink' => 'CdiEntity\View\Helper\CustomEntityLink',
            )
        ),
    'view_manager' => array(
        'template_path_stack' => array(
            'cdientity' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'CDIENTITY',
                'uri' => '#',
                'detail' => "",
                'icon' => 'fa fa-puzzle-piece ',
                'resource' => 'adm',
                'privilege' => 'abm',
                'uri' => '/cdientity/namespaces/abm',

            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'centity' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cdientity/entity/:action[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CdiEntity\Controller\Entity',
                        'action' => 'abm',
                    ),
                ),
            ),
            'cproperty' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cdientity/property/:action[/:id][/:eid][/:rid]',
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
            'cnamespaces' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cdientity/namespaces/:action[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CdiEntity\Controller\Namespaces',
                        'action' => 'abm',
                    ),
                ),
            ),
            'cmain' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cdientity/main[/:action][/:id][/:eid]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CdiEntity\Controller\Main',
                        'action' => 'abm',
                    ),
                ),
            ),
        ),
    ),
);


