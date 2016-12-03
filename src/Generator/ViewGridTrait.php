<?php

namespace CdiEntity\Generator;

/**
 * Description of MenuTrait
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
Trait ViewGridTrait {

    public function generateViewGrid(\CdiEntity\Entity\Controller $controller) {

       $entity = $controller->getEntity(); 

        //FILE
        $file = new \Zend\Code\Generator\FileGenerator();
      
        
        $file->setBody($this->getGridBody($entity));
        

        // UPDATE the generated file
        try {
            $path = $entity->getNamespace()->getPath() . "/view/" . lcfirst($entity->getNamespace()->getName()."/".lcfirst($entity->getName()));
            $fileName = $path . "/grid.phtml";
            
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
    
    
    protected function getGridBody($entity){
                $return = '<div class="row">' . PHP_EOL;
        $return .= '<div class="col-12">' . PHP_EOL;
        $return .= '<div class="panel panel panel-primary">' . PHP_EOL;
        $return .= '<div class="panel-heading">' . PHP_EOL;
        $return .= '<h4 class="panel-title">'.$this->entity->getName().'</h4>'.PHP_EOL;
        $return .= ' </div>' . PHP_EOL;
        $return .= '<div class="panel-body">' . PHP_EOL;
        $return .= '<?php echo $this->CdiGrid($this->grid); ?>' . PHP_EOL;
        $return .= '</div>' . PHP_EOL;
        $return .= '</div>' . PHP_EOL;
        $return .= '</div>' . PHP_EOL;
        $return .= '</div>' . PHP_EOL;
        $return .= '' . PHP_EOL;
        
        return $return;
        
    }

}
