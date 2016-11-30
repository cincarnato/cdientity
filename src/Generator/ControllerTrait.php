<?php

namespace CdiEntity\Generator;

/**
 * Description of MenuTrait
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
Trait ControllerTrait {

    //CONTROLLER
    public function generateController(\CdiEntity\Entity\Controller $controller) {

        $namespace = $controller->getEntity()->getNamespace()->getName() . "\Controller";

        //CLASS
        $class = new \Zend\Code\Generator\ClassGenerator();
        $class->setName($controller->getEntity()->getName() . "Controller");

        //DOC
        $dc = new \Zend\Code\Generator\DocBlockGenerator();
        $a = array(
            array("name" => 'Controller'),
        );
        $dc->setTags($a);
        $class->setDocBlock($dc);

        //NAMESPACE
        $class->setNamespaceName($namespace);

        //USE
        $class->addUse("Zend\Mvc\Controller\AbstractActionController");

        //EXTEND
        $class->setExtendedClass("\Zend\Mvc\Controller\AbstractActionController");


        //EM

        $p = new \Zend\Code\Generator\PropertyGenerator();
        $p->setName("em");
        $d = new \Zend\Code\Generator\DocBlockGenerator();
        $a = [["name" => 'var \Doctrine\ORM\EntityManager']];
        $d->setTags($a);
        $p->setDocBlock($d);
        $mg = $this->generateGetter("em");
        $ms = $this->generateSetter("em", "\Doctrine\ORM\EntityManager");
        $class->addPropertyFromGenerator($p);
        $class->addMethodFromGenerator($mg);
        $class->addMethodFromGenerator($ms);

        //GRID
        $p = new \Zend\Code\Generator\PropertyGenerator();
        $p->setName("grid");
        $d = new \Zend\Code\Generator\DocBlockGenerator();
        $a = [["name" => 'var \CdiDataGrid\Grid']];
        $d->setTags($a);
        $p->setDocBlock($d);
        $mg = $this->generateGetter("grid");
        $ms = $this->generateSetter("grid", "\CdiDataGrid\Grid");
        $class->addPropertyFromGenerator($p);
        $class->addMethodFromGenerator($mg);
        $class->addMethodFromGenerator($ms);



        $class->addMethodFromGenerator($this->genConstruct());
        $class->addMethodFromGenerator($this->genGridAction());

        //FILE
        $file = new \Zend\Code\Generator\FileGenerator();
        $file->setClass($class);

        // UPDATE the generated file
        try {
            $path = $controller->getEntity()->getNamespace()->getPath() . "/src/Controller/";
            $fileName = $controller->getEntity()->getNamespace()->getPath() . "/src/Controller/" . $controller->getEntity()->getName() . "Controller.php";

            if (!file_exists($fileName)) {
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                file_put_contents(
                        $fileName, $file->generate());
            }
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    protected function genConstruct() {

        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName("__construct");

        //BODY
        $sourceContent = ' $this->em = $em;' . PHP_EOL;
        $sourceContent .= ' $this->grid = $grid;' . PHP_EOL;
        $method->setBody($sourceContent);

        //PARAMETERS
        $em = new \Zend\Code\Generator\ParameterGenerator("em", "\Doctrine\ORM\EntityManager");
        $grid = new \Zend\Code\Generator\ParameterGenerator("grid", "\CdiDataGrid\Grid");

        $method->setParameter($em);
        $method->setParameter($grid);
        return $method;
    }

    protected function genGridAction() {

        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName("gridAction");

        //BODY
        $sourceContent = '$this->grid->prepare();' . PHP_EOL;
        $sourceContent .= 'return array("grid" => $this->grid);' . PHP_EOL;
        $method->setBody($sourceContent);

        return $method;
    }

}
