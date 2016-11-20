<?php
namespace CdiEntity;
$setting =  array(
    'cdientity_options' => array(
        'script_update_schema' => '',
        'autoupdate' => false
    ),
    'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'cdientity_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'CdiEntity\Entity' => 'cdientity_entity',
                ),
            ),
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
                'permission' => 'cdientity',
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
                        'controller' => Controller\EntityController::class,
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
                        'controller' => Controller\PropertyController::class,
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
                        'controller' => Controller\NamespacesController::class,
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
                        'controller' => Controller\MainController::class,
                        'action' => 'abm',
                    ),
                ),
            ),
        ),
    ),
     'zfc_rbac' => [
        'guards' => [
            'ZfcRbac\Guard\RouteGuard' => [
                'centity' => ['admin'],
                'cproperty' => ['admin'],
                'cnamespaces' => ['admin'],
                'cmain' => ['admin'],
            ]
        ],
    ]
    
);

$cdiDatagridCustomConfig = include 'cdi-datagrid-custom.config.php';

$setting = array_merge($setting,$cdiDatagridCustomConfig);

return $setting;
