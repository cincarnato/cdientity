<?php

namespace CdiEntity\Generator;

/**
 * Description of MenuTrait
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
Trait RouteConfigTrait {

    public function generateRouteConfig(\CdiEntity\Entity\Namespaces $namespace, $menus) {


        //INIT MENU
        $body = "<?php " . PHP_EOL;
        $body .= "return [  'router' => [" . PHP_EOL;
           $body .= "'routes' =>[" . PHP_EOL;

         foreach ($menus as $menu) {

            $body .= $this->routeConfig($menu);
        }


        //FIN MENU
        $body .= "]]];" . PHP_EOL;

        $file = new \Zend\Code\Generator\FileGenerator();
        $file->setBody(trim($body," \t\n\r\0\x0B"));

        try {
            $path = $namespace->getPath() . "/config/";
            $fileName = $path . "cdie-route.config.php";

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            file_put_contents(
                    $fileName, trim($file->generate()," \t\n\r\0\x0B"));
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    protected function routeConfig(\CdiEntity\Entity\Menu $menu) {
        $return = "";
        if($menu->getEntity()){
        $controllerName = "\\".$menu->getNamespace()."\Controller\\".$menu->getEntity()->getName()."Controller::class";
            
        if(empty($menu->getRouteName())){
            $routeName = $menu->getEntity()->getNamespace()->getName()."_".$menu->getEntity()->getName();
        }else{
            $routeName = $menu->getRouteName();
        }
        
        
       $return = "'".$routeName."' => [" . PHP_EOL;
        $return .= "'type' => 'literal'," . PHP_EOL;
        $return .= "  'options' => [" . PHP_EOL;
        $return .= " 'route' => '" . $menu->getUri() . "'," . PHP_EOL;
        $return .= " 'defaults' => [" . PHP_EOL;
         $return .= " 'controller' =>".$controllerName."," . PHP_EOL;
        $return .= " 'action' => 'grid'," . PHP_EOL;
        $return .= "]," . PHP_EOL;
        $return .= "]," . PHP_EOL;
        $return .= "]," . PHP_EOL;
        }
         if ($menu->getChilds()->count()) {
            foreach ($menu->getChilds() as $child) {
               $return .= $this->routeConfig($child);
            }
        }
        
        return $return;
        
    }

}
