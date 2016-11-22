<?php


namespace CdiEntity\Generator;
/**
 * Description of GetterSetterTrait
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
Trait GetterSetterTrait {
    
    
     protected function generateGetter($name) {
        $mg = new \Zend\Code\Generator\MethodGenerator ( );
        $mg->setName(
                "get" . ucfirst($name));
        $mg->setBody('return $this->' . $name . ";");
        return $mg;
    }

    protected function generateSetter($name,$type = null) {
        
        $parameter = new \Zend\Code\Generator\ParameterGenerator($name, $type);
        
        $ms = new \Zend\Code\Generator\MethodGenerator ( );
        $ms->setName("set" . ucfirst($name));
        $ms->setBody(
                '$this->' . $name . " = $" . $name . ";");
        $ms->setParameter($parameter);
        return $ms;
    }
}
