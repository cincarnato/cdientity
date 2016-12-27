<?php

namespace CdiEntity\Factory\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiEntity\Service\Editor;

class CodeGeneratorFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {
        $service = new \CdiEntity\Service\CodeGenerator();
        return $service;
    }

}
