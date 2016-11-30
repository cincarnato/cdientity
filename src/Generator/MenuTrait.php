<?php
namespace CdiEntity\Generator;
/**
 * Description of MenuTrait
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
Trait MenuTrait {

    public function generateMenu(\CdiEntity\Entity\Namespaces $namespace, $menus) {


        //INIT MENU
        $aMenus = "<?php " . PHP_EOL;
        $aMenus .= "return array('navigation' => array('default' => array(" . PHP_EOL;

        foreach ($menus as $menu) {

            $aMenus .= $this->menuConfig($menu);
        }

        //FIN MENU
        $aMenus .= ")));" . PHP_EOL;

        $file = new \Zend\Code\Generator\FileGenerator();
        $file->setBody($aMenus);

        try {
            $path = $namespace->getPath() . "/config/";
            $fileName = $path . "cdie-menu.config.php";

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            file_put_contents(
                    $fileName, $file->generate());
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    protected function menuConfig($menu) {
        $return = " array(" . PHP_EOL;
        $return .= " 'label' => '" . $menu->getLabel() . "'," . PHP_EOL;
        $return .= " 'uri' => '" . $menu->getUri() . "'," . PHP_EOL;
        $return .= " 'icon' => '" . $menu->getIcon() . "'," . PHP_EOL;
        $return .= " 'permission' => '" . $menu->getPermission() . "'," . PHP_EOL;
        if ($menu->getChilds()->count()) {
            $return .= " 'pages' => array(" . PHP_EOL;
            foreach ($menu->getChilds() as $child) {
                $return .= $this->menuConfig($child);
            }
            $return .= ")," . PHP_EOL;
        }
        $return .= ")," . PHP_EOL;
        return $return;
    }

}
