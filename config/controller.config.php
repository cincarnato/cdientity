<?php
namespace Application;
use Zend\ServiceManager\Factory\InvokableFactory;

return array(
    'factories' => [
        Controller\IndexController::class => InvokableFactory::class,
        Controller\GridController::class => \Application\Factory\GridControllerFactory::class,
         Controller\GridMethodController::class => \Application\Factory\GridMethodControllerFactory::class,
    ],
);

