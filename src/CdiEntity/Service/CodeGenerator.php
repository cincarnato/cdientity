<?php

namespace CdiEntity\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;

/**
 * TITLE
 *
 * Description
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 *
 * @package Paquete
 */
class CodeGenerator implements ServiceManagerAwareInterface {

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function update(\CdiEntity\Entity\Entity $entity, $updateSchema = true) {
        $class = Zend\Code\Generator\ClassGenerator::fromReflection(
                        new Zend\Code\Reflection\ClassReflection($entity->getName())
        );

        $file = new Zend\Code\Generator\FileGenerator();
        $file->setClass($class);

// Render the generated file
        return $file->generate();
    }

    protected function booleanString($value) {
        if ($value) {
            return "true";
        } else {
            return "false";
        }
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager() {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $serviceManager
     * @return User
     */
    public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
        return $this;
    }

}
