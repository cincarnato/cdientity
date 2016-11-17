<?php

namespace CdiEntity;


/**
 * Module
 *
 * @package   Cdi
 * @copyright Cristian Incarnato (c) - http://www.cincarnato.com
 */
class Module {

    public function init() {
        
    }
    
    
    public function getControllerConfig() {
        return include __DIR__ . '/../config/controller.config.php';
    }
  

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig() {
            return include __DIR__ . '/../config/services.config.php';
    }

  

}
