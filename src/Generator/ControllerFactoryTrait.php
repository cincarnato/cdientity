<?php

namespace CdiEntity\Generator;

/**
 * Description of ControllerFactoryTrait
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
Trait ControllerFactoryTrait {

    public function generateControllerFactory(\CdiEntity\Entity\Controller $controller) {

        $namespace = $controller->getEntity()->getNamespace()->getName() . "\Factory\Controller";


        //CLASS
        $class = new \Zend\Code\Generator\ClassGenerator();
        $class->setName($controller->getEntity()->getName() . "ControllerFactory");

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
        $class->addUse("Zend\ServiceManager\Factory\FactoryInterface");

        //EXTEND
        $class->setImplementedInterfaces(["\Zend\ServiceManager\Factory\FactoryInterface"]);


        $class->addMethodFromGenerator($this->generateInvoke($controller));

        //FILE
        $file = new \Zend\Code\Generator\FileGenerator();
        $file->setClass($class);

        // UPDATE the generated file
        try {
            $path = $controller->getEntity()->getNamespace()->getPath() . "/src/Factory/Controller/";
            $fileName = $controller->getEntity()->getNamespace()->getPath() . "/src/Factory/Controller/" . $controller->getEntity()->getName() . "ControllerFactory.php";

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            file_put_contents(
                    $fileName, $file->generate());
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    protected function generateInvoke($controller) {

        $EntityName = $controller->getEntity()->getName();
        $namespace = $controller->getEntity()->getNamespace()->getName();

        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName("__invoke");

        //BODY
        $sourceContent = '/* @var $grid \CdiDataGrid\Grid */' . PHP_EOL;
        $sourceContent .= '$grid = $container->build("CdiDatagrid", ["customOptionsKey" => "cdiEntity' . $EntityName . '"]);' . PHP_EOL;
        $sourceContent .= '$em = $container->get("Doctrine\ORM\EntityManager");' . PHP_EOL;
        $sourceContent .= 'return new \\' . $namespace . '\Controller\\' . $EntityName . 'Controller($em,$grid);' . PHP_EOL;
        $method->setBody($sourceContent);

        //PARAMETERS
        $container = new \Zend\Code\Generator\ParameterGenerator("container", "\Interop\Container\ContainerInterface");
        $requestedName = new \Zend\Code\Generator\ParameterGenerator("requestedName");
        $options = new \Zend\Code\Generator\ParameterGenerator("options", "array");
        $options->setDefaultValue(null);

        $method->setParameter($container);
        $method->setParameter($requestedName);
        $method->setParameter($options);


        return $method;
    }

    //FROM REFLECTION
    public function generateControllerFactoryReflection(\CdiEntity\Entity\Controller $controller) {

        $file = new \Zend\Code\Generator\FileGenerator();

        require __DIR__ . '/../GeneratorTemplates/Factory/Controller/TemplateControllerFactory.php';
        $reflection = new \Zend\Code\Reflection\FileReflection(__DIR__ . '/../GeneratorTemplates/Factory/Controller/TemplateControllerFactory.php');

        $file->fromReflection($reflection);
        // UPDATE the generated file
        try {
            $path = $controller->getNamespace()->getPath() . "/Factory/Controller/";
            $fileName = $controller->getNamespace()->getPath() . "/Factory/Controller/" . $controller->getEntity()->getName() . "Controller.php";

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

}
