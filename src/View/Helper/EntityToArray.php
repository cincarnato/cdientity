<?php

namespace CdiEntity\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * @author cincarnato
 */
class EntityToArray extends AbstractHelper {


    /**
     * Invoke helper
     *
     * Proxies to {@link render()}.
     *
     * @param  InterfaceColumn $column
     * @param  array $data
     * @return string
     */
    public function __invoke($entity) {

        if(method_exists($entity, "toArray")){
            $list = $entity->toArray();
        }else{
            $list = $this->toArray($entity);
        }


        return $list;
    }

    
     protected function toArray($entity) {
        $list = array();
        foreach (get_object_vars($entity) as $key => $value) {
            if (substr($key, 0, 1) != '_') {
                if (is_object($value)) {
                    $list[$key] = $this->toArray($value);
                } else {
                    $list[$key] = $value;
                }
            }
        }

        return $list;
    }
 

}

?>
