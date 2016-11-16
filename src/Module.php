<?php

namespace CdiEntity;


use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

/**
 * Module
 *
 * @package   Cdi
 * @copyright Cristian Incarnato (c) - http://www.cincarnato.com
 */
class Module implements AutoloaderProviderInterface {

    public function init() {
        
    }
    
    
    public function getControllerConfig() {
        return include __DIR__ . '/../config/controller.config.php';
    }
  
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig() {
            return include __DIR__ . '/../config/services.config.php';
    }

  

}
