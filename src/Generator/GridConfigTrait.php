<?php

namespace CdiEntity\Generator;

/**
 * Description of MenuTrait
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
Trait GridConfigTrait {

    public function generateDatagridConfig(\CdiEntity\Entity\Namespaces $namespace, $controllers) {


        //INIT MENU
        $body = "<?php " . PHP_EOL;
        $body .= "return [" . PHP_EOL;

        foreach ($controllers as $controller) {

            $body .= $this->gridConfig($controller);
        }

        //FIN MENU
        $body .= "];" . PHP_EOL;

        $file = new \Zend\Code\Generator\FileGenerator();
        $file->setBody($body);

        try {
            $path = $namespace->getPath() . "/config/";
            $fileName = $path . "cdie-datagrid.config.php";

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            file_put_contents(
                    $fileName, trim($file->generate()," \t\n\r\0\x0B"));
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    protected function gridConfig(\CdiEntity\Entity\Controller $controller) {

        $nameConfig = "cdigrid_".$controller->getEntity()->getNamespace()->getName()."_". $controller->getEntity()->getName();


        $return = "'" . $nameConfig . "' => [" . PHP_EOL;
        $return .= "'sourceConfig' => [" . PHP_EOL;
        $return .= "'type' => 'doctrine'," . PHP_EOL;
        $return .= '"doctrineOptions" => [' . PHP_EOL;
        $return .= '"entityName" => "\\'.$controller->getEntity()->getNamespace()->getName().'\Entity\\'.$controller->getEntity()->getName().'",' . PHP_EOL;
        $return .= '"entityManager" => "Doctrine\ORM\EntityManager"' . PHP_EOL;
        $return .= '],' . PHP_EOL;
        $return .= '],' . PHP_EOL;
        $return .= '],' . PHP_EOL;




        return $return;
    }

}
