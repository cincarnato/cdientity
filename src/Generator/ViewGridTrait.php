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
        
        $viewDirName = $this->normaliceViewDirName($entity->getName());
      

        // UPDATE the generated file
        try {
            $path = $entity->getNamespace()->getPath() . "/view/" . lcfirst($entity->getNamespace()->getName()."/".$viewDirName);
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
    
    protected function normaliceViewDirName($entityName){
        $string=  lcfirst($entityName);
        
        $aString = str_split($string);
        $return = "";
        foreach($aString as $char){
            if(ctype_upper($char)){
                $return .= "-".lcfirst($char);
            }else{
                 $return .= $char;
            }
        }
        return $return;
    }
    
    
    
    protected function getGridBody(\CdiEntity\Entity\Entity $entity){
                $return = '<div class="row">' . PHP_EOL;
        $return .= '<div class="col-12">' . PHP_EOL;
        $return .= '<div class="panel panel panel-primary">' . PHP_EOL;
        $return .= '<div class="panel-heading">' . PHP_EOL;
        $return .= '<h4 class="panel-title">'.$entity->getName().'</h4>'.PHP_EOL;
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
