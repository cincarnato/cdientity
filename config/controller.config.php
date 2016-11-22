<?php

namespace CdiEntity;

//use Zend\ServiceManager\Factory\InvokableFactory;

return array(
    'factories' => [
        \CdiEntity\Controller\NamespacesController::class => \CdiEntity\Factory\Controller\NamespacesControllerFactory::class,
        \CdiEntity\Controller\EntityController::class => \CdiEntity\Factory\Controller\EntityControllerFactory::class,
        \CdiEntity\Controller\PropertyController::class => \CdiEntity\Factory\Controller\PropertyControllerFactory::class,
        \CdiEntity\Controller\MainController::class => \CdiEntity\Factory\Controller\MainControllerFactory::class,
        \CdiEntity\Controller\MenuController::class => \CdiEntity\Factory\Controller\MenuControllerFactory::class,
        \CdiEntity\Controller\ControllerController::class => \CdiEntity\Factory\Controller\ControllerControllerFactory::class,
    ],
);

