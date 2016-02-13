<?php

return array(
    'cdientity_options' => array(
    ),
     'controllers' => array(
        'invokables' => array(
            'usersession' => 'CdiUser\Controller\UserSessionController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'cdiuser' => array(
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


