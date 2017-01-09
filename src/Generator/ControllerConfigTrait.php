<?php
namespace CdiEntity\Generator;
/**
 * Description of MenuTrait
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
Trait ControllerConfigTrait {

    public function generateControllerConfig(\CdiEntity\Entity\Namespaces $namespace, $controllers) {


        //INIT MENU
        $body = "<?php " . PHP_EOL;
        $body .= "return [" . PHP_EOL;
        $body .= "'controllers' => [" . PHP_EOL;
        $body .= "'factories' => [" . PHP_EOL;

        foreach ($controllers as $controller) {

            $body .= $this->controllerConfig($controller);
        }

        //FIN MENU
        $body .= "]," . PHP_EOL;
        $body .= "]," . PHP_EOL;
        $body .= "];" . PHP_EOL;

        $file = new \Zend\Code\Generator\FileGenerator();
        $file->setBody(trim($body," \t\n\r\0\x0B"));

        try {
            $path = $namespace->getPath() . "/config/";
            $fileName = $path . "cdie-controller.config.php";

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            file_put_contents(
                    $fileName, trim($file->generate()," \t\n\r\0\x0B"));
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    protected function controllerConfig($controller) {
        $namespace = $controller->getEntity()->getNamespace()->getName();
        $controllerName = $controller->getEntity()->getName();

        $class = "\\" . $namespace . "\Controller\\" . $controllerName . "Controller::class";
        $factory = "\\" . $namespace . "\Factory\Controller\\" . $controllerName . "ControllerFactory::class";

        $return = $class . " => " . $factory . "," . PHP_EOL;

        return $return;
    }

}
