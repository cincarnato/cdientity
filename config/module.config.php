<?php

namespace CdiEntity;


$setting = array(
    'cdientity_options' => array(
        'script_update_schema' => '',
        'autoupdate' => false
    ),
    'doctrine' => array(
        'connection' => array(
            'orm_cdientity' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => array(
                    'path' => __DIR__ . '/../../../../data/cdientity/cdientity.db',
                )
            )
        ),
        'entitymanager' => array(
            'orm_cdientity' => array(
                'connection' => 'orm_cdientity',
                'configuration' => 'conf_cdientity'
            ),
        ),
        'eventmanager' => array(
            'orm_cdientity' => array(
                'subscribers' => array(
                    'Gedmo\Timestampable\TimestampableListener',
                ),
            ),
        ),
          'configuration' => array(
            'conf_cdientity' => array(
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'driver' => 'drv_cdientity', // This driver will be defined later
                'generate_proxies' => true,
                'proxy_dir' => 'data/DoctrineORMModule/Proxy',
                'proxy_namespace' => 'DoctrineORMModule\Proxy',
                'filters' => array()
            )
        ),
        'driver' => array(
            'cdientity_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../src/Entity')
            ),
            'drv_cdientity' => array(
                'class' => "Doctrine\ORM\Mapping\Driver\DriverChain",
                'drivers' => array(
                    'CdiEntity\Entity' => 'cdientity_entity',
                ),
            ),
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'CustomEntityLink' => 'CdiEntity\View\Helper\CustomEntityLink',
            'EntityToArray' => 'CdiEntity\View\Helper\EntityToArray',
            'CdiEntityRenderEditor' => 'CdiEntity\View\Helper\CdiEntityRenderEditor',
            'CdiEntityRenderForm' => 'CdiEntity\View\Helper\CdiEntityRenderForm',
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
                'label' => 'CdiGenerator',
                'detail' => "",
                'icon' => 'fa fa-sitemap ',
                'permission' => 'cdientity',
                'uri' => '',
                "pages" => array(
                    array(
                        'label' => 'CdiEntity',
                        'detail' => "",
                        'icon' => 'fa fa-map-signs ',
                        'permission' => 'cdientity',
                        'uri' => '/cdientity/namespaces/abm',
                    ),
                    array(
                        'label' => 'CdiController',
                        'detail' => "",
                        'icon' => 'fa fa-tasks',
                        'permission' => 'cdientity',
                        'uri' => '/cdientity/controller/abm',
                    ),
                    array(
                        'label' => 'CdiMenu',
                        'detail' => "",
                        'icon' => 'fa fa-ellipsis-h',
                        'permission' => 'cdientity',
                        'uri' => '/cdientity/menu/abm',
                    ),
                ),
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'ccontroller_factory_config' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/cdientity/controller/update-factory-config',
                    'defaults' => array(
                        'controller' => Controller\ControllerController::class,
                        'action' => 'update-factory-config',
                    ),
                ),
            ),
            'ccontroller' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cdientity/controller/:action[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => Controller\ControllerController::class,
                        'action' => 'abm',
                    ),
                ),
            ),
            'cmenu' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/cdientity/menu/abm',
                    'defaults' => array(
                        'controller' => Controller\MenuController::class,
                        'action' => 'abm',
                    ),
                ),
            ),
            'cmenuupdate' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/cdientity/menu/update',
                    'defaults' => array(
                        'controller' => Controller\MenuController::class,
                        'action' => 'update',
                    ),
                ),
            ),
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
                    'route' => '/cdientity/main[/:action][/:id][/:eid][/:rid]',
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
            'cdi_entity_editor' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cdientity/editor/:action/:entityId[/:objectId]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'eid' => '[0-9]+',
                        'oid' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => Controller\EditorController::class,
                        'action' => 'editor',
                    ),
                ),
            ),
            'cdi_entity_otm' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cdientity/otm/:action/:entityId/:parentEntityId/:parentObjectId',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'entityId' => '[0-9]+',
                        'parentEntityId' => '[0-9]+',
                        'parentObjectId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => Controller\OtmController::class,
                        'action' => 'ajax',
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
                'ccontroller' => ['admin'],
                'cmenu*' => ['admin'],
                'cdi_entity_editor' => ['admin'],
                'cdi_entity_otm' => ['admin'],
            ]
        ],
    ]
);

$cdiDatagridCustomConfig = include 'cdi-datagrid-custom.config.php';

$setting = array_merge($setting, $cdiDatagridCustomConfig);

return $setting;
