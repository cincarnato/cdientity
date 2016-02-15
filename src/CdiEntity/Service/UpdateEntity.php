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
class UpdateEntity  {

    public function applyChanges(CdiEntity\Entity\Entity $entity) {

        if ($entity->getProperties()->count()) {
            $newcontent = "//cdientitystart";
            foreach ($entity->getProperties() as $property) {
                $newcontent .= "protected " . $property->getName() . ";";
            }
            $newcontent .= "\n";
            $newcontent = "//cdientityend";




            $path_to_file = $entity->getPath();
            $file_contents = file_get_contents($path_to_file);
            $file_contents = preg_replace("/\/\/cdientitystart.*\/\/cdientityend/", $newcontent, $file_contents);
            file_put_contents($path_to_file, $file_contents);
        }
    }

}
