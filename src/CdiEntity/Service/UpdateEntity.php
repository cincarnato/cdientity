<?php

namespace CdiEntity\Service;

//use Zend\ServiceManager\ServiceManagerAwareInterface;

/**
 * TITLE
 *
 * Description
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 *
 * @package Paquete
 */
class UpdateEntity {

    public function applyChanges(\CdiEntity\Entity\Entity $entity) {

        if ($entity->getProperties()->count()) {
            $newcontent = '//cdientitystart';
            $newcontent .= PHP_EOL.PHP_EOL;




            foreach ($entity->getProperties() as $property) {

                //Docblocks for anotattions

                $newcontent .= '/**' . PHP_EOL;
                $newcontent .= '* @Annotation\Options({"label":"'.$property->getName().':"})' . PHP_EOL;
               
                switch ($property->getType()) {
                    case "string":
                         $newcontent .= '* @Annotation\Attributes({"type":"text"})' . PHP_EOL;
                        $newcontent .= '* @ORM\Column(type="string", length=' . $property->getLength() . ', unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $property->getTblName() . '")/*' . PHP_EOL;
                        break;
                    case "integer":
                          $newcontent .= '* @Annotation\Attributes({"type":"text"})' . PHP_EOL;
                        $newcontent .= '* @ORM\Column(type="integer", length=' . $property->getLength() . ', unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $property->getTblName() . '")/*' . PHP_EOL;
                        break;
                    case "text":
                          $newcontent .= '* @Annotation\Attributes({"type":"textarea"})' . PHP_EOL;
                        $newcontent .= '* @ORM\Column(type="text", unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $property->getTblName() . '")/*' . PHP_EOL;
                        break;
                    case "boolean":
                          $newcontent .= '* @Annotation\Attributes({"type":"checkbox"})' . PHP_EOL;
                        $newcontent .= '* @ORM\Column(type="boolean", nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $property->getTblName() . '")/*' . PHP_EOL;
                        break;
                }

                $newcontent .= '*/' . PHP_EOL;

                //Property
                $newcontent .= 'protected $' . $property->getName() . ';';
                $newcontent .= PHP_EOL . PHP_EOL;

                //Getter
                $newcontent .= 'public function get' . ucfirst($property->getName()) . '(){';
                $newcontent .= 'return $this->' . $property->getName() . ';';
                $newcontent .= '}';

                $newcontent .= PHP_EOL . PHP_EOL;

                //Setter
                $newcontent .= 'public function set' . ucfirst($property->getName()) . '($' . $property->getName() . '){';
                $newcontent .= '$this->' . $property->getName() . '= $' . $property->getName() . ';';
                $newcontent .= '}';

                $newcontent .= PHP_EOL . PHP_EOL;
            }

            $newcontent .= '//cdientityend';



            $path_to_file = $entity->getPath();
            $file_contents = file_get_contents($path_to_file);
            $file_contents = preg_replace("/\/\/cdientitystart(.*\n)*\s*\/\/cdientityend/", $newcontent, $file_contents);

            //   $file_contents = preg_replace("/\/\/cdientity/", $newcontent, $file_contents);

            file_put_contents($path_to_file, $file_contents);
        }
    }
    
    protected function booleanString($value){
        if($value){
            return "true";
        }else{
            return "false";
        }
    }

}
