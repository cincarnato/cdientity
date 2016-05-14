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
//        $class = \Zend\Code\Generator\ClassGenerator::fromReflection(
//                        new \Zend\Code\Reflection\ClassReflection($entity->getName())
//        );


        $class = new \Zend\Code\Generator\ClassGenerator();
        $class->setName($entity->getName());

        $dc = new \Zend\Code\Generator\DocBlockGenerator();
        $a = array(
            array("name" => 'ORM\Entity'),
            array("name" => 'ORM\Table(name="cmdb_' . $entity->getName() . '")'),
        );
        $dc->setTags($a);
        $class->setDocBlock($dc);
        $class->setNamespaceName($entity->getNamespace()->getName());
        $class->addUse("Doctrine\Common\Collections\ArrayCollection");
        $class->addUse("Zend\Form\Annotation");
        $class->addUse("Doctrine\ORM\Mapping", "ORM");
        
        
        $class->setExtendedClass("\CdiCommons\Entity\BaseEntity");
        
        //Genero campo ID
        $p = new \Zend\Code\Generator\PropertyGenerator();
        $p->setName("id");
        $d = new \Zend\Code\Generator\DocBlockGenerator();
        $a = array(
            array("name" => 'ORM\Id'),
            array("name" => 'ORM\Column(type="integer")'),
            array("name" => 'ORM\GeneratedValue(strategy="AUTO")'),
            array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")'),
        );
        $d->setTags($a);
        $p->setDocBlock($d);
        $mg = $this->generateGetter("id");
        $ms = $this->generateSetter("id");
        $class->addPropertyFromGenerator($p);
        $class->addMethodFromGenerator($mg);
        $class->addMethodFromGenerator($ms);

        $m = $this->generateToString("id");
        $class->addMethodFromGenerator($m);

        $toString = true;
        foreach ($entity->getProperties() as $property) {
            //Propertie
            $p = new \Zend\Code\Generator\PropertyGenerator();
            $p->setName($property->getName());

            if ($toString == true && $property->getType() == "string") {
                $class->removeMethod("__toString");
                $m = $this->generateToString($property->getName());
                $class->addMethodFromGenerator($m);
                $toString = false;
            }

            //DocBlock
            $d = $this->generateDoc($property,$entity);
            $p->setDocBlock($d);

            //Getter
            $mg = $this->generateGetter($property->getName());

            //Setter
            $ms = $this->generateSetter($property->getName());

            //Asign
            $class->addPropertyFromGenerator($p);
            $class->addMethodFromGenerator($mg);
            $class->addMethodFromGenerator($ms);
        }

        
        
        $file = new \Zend\Code\Generator\FileGenerator();
        $file->setClass($class);

// Render the generated file
        $this->updateFile($entity, $file->generate());

        if ($updateSchema) {
            $cdientity_options = $this->getServiceManager()->get('cdientity_options');

            return exec($cdientity_options->getScriptUpdateSchema());
        } else {
            return "NA";
        }
    }
    
       protected function toArray() {
        $mg = new \Zend\Code\Generator\MethodGenerator();
        $mg->setName("toArray");
        $mg->setBody('return (array) $this;');
        return $mg;
    }

    public function updateFile($entity, $file_contents) {
        file_put_contents($entity->getPath() . "/" . $entity->getName() . ".php", $file_contents);
    }

    protected function generateDoc($property,$entity) {
        switch ($property->getType()) {
            case "string":
                $d = new \Zend\Code\Generator\DocBlockGenerator();
                $a = array(
                    array("name" => 'Annotation\Attributes({"type":"text"})'),
                    array("name" => 'Annotation\Options({"label":"' . $property->getName() . '"})'),
                    array("name" => 'ORM\Column(type="string", length=' . $property->getLength() . ', unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . strtolower($property->getName()) . '")'),
                );
                $d->setTags($a);
                break;
            case "integer":
                $d = new \Zend\Code\Generator\DocBlockGenerator();
                $a = array(
                    array("name" => 'Annotation\Attributes({"type":"text"})'),
                    array("name" => 'Annotation\Options({"label":"' . $property->getName() . '"})'),
                    array("name" => 'ORM\Column(type="integer", length=' . $property->getLength() . ', unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . strtolower($property->getName()) . '")'),
                );
                $d->setTags($a);
                break;
            case "text":
                $d = new \Zend\Code\Generator\DocBlockGenerator();
                $a = array(
                    array("name" => 'Annotation\Attributes({"type":"textarea"})'),
                    array("name" => 'Annotation\Options({"label":"' . $property->getName() . '"})'),
                    array("name" => 'ORM\Column(type="text", unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . strtolower($property->getName()) . '")'),
                );
                $d->setTags($a);
                break;
            case "boolean":
                $d = new \Zend\Code\Generator\DocBlockGenerator();
                $a = array(
                    array("name" => 'Annotation\Type("Zend\Form\Element\Checkbox")'),
                    array("name" => 'Annotation\Attributes({"type":"checkbox"})'),
                    array("name" => 'Annotation\Options({"label":"' . $property->getName() . '"})'),
                    array("name" => 'ORM\Column(type="boolean", nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . strtolower($property->getName()) . '")'),
                );
                $d->setTags($a);
                break;
            case "oneToOne":
                $d = new \Zend\Code\Generator\DocBlockGenerator();
                $a = array(
                    array("name" => 'Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")'),
                    array("name" => 'Annotation\Options({"label":"' . $property->getName() . ':","empty_option": "","target_class":"' . $property->getRelatedEntity()->getFullName() . '"})'),
                    array("name" => 'ORM\OneToOne(targetEntity="' . $property->getRelatedEntity()->getFullName() . '")'),
                );
                $d->setTags($a);
                break;
            case "manyToOne":
                $d = new \Zend\Code\Generator\DocBlockGenerator();
                $a = array(
                    array("name" => 'Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")'),
                    array("name" => 'Annotation\Options({"label":"' . $property->getName() . ':","empty_option": "","target_class":"' . $property->getRelatedEntity()->getFullName() . '"})'),
                    array("name" => 'ORM\ManyToOne(targetEntity="' . $property->getRelatedEntity()->getFullName() . '")'),
                );
                $d->setTags($a);
                break;
            case "oneToMany":

                $d = new \Zend\Code\Generator\DocBlockGenerator();
                $a = array(
                     array("name" => 'Annotation\Exclude()'),
                    array("name" => 'ORM\OneToMany(targetEntity="' . $property->getRelatedEntity()->getFullName() . '", mappedBy="' . $entity->getName() . '")'),
                );
                $d->setTags($a);
                break;
        }
        return $d;
    }

    protected function generateGetter($name) {
        $mg = new \Zend\Code\Generator\MethodGenerator();
        $mg->setName("get" . ucfirst($name));
        $mg->setBody('return $this->' . $name . ";");
        return $mg;
    }

    protected function generateSetter($name) {
        $ms = new \Zend\Code\Generator\MethodGenerator();
        $ms->setName("set" . ucfirst($name));
        $ms->setBody('$this->' . $name . " = $" . $name . ";");
        $ms->setParameter($name);
        return $ms;
    }

    protected function generateToString($name) {
        $m = new \Zend\Code\Generator\MethodGenerator();
        $m->setName("__toString");
        $m->setBody('return (string) $this->' . $name . ";");
        return $m;
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
