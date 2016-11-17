<?php

namespace CdiEntity\View\Helper;

use Zend\View\Helper\AbstractHelper;
use CdiDataGrid\Column\ColumnInterface;

/**
 * @author cincarnato
 */
class CustomEntityLink extends AbstractHelper {


    /**
     * Invoke helper
     *
     * Proxies to {@link render()}.
     *
     * @param  InterfaceColumn $column
     * @param  array $data
     * @return string
     */
    public function __invoke(ColumnInterface $column, array $data) {



        return $this->render($column, $data);
    }

    /**
     * Render a Field from the provided $column and $data
     *
     * @param  InterfaceColumn $column
     * @param  array $data
     * @return string
     */
    public function render(ColumnInterface $column, array $data) {
        
        $value = $data[$column->getName()];
        $customData = $column->getData();
        $eid = $customData["eid"];
      //  var_dump($data[$column->getName()]);
        if($data[$column->getName()]){
              $id = $data[$column->getName()]->getId();
        }
      
        
        return "<a href='/cdientity/main/view/".$id."/".$eid."' target='_blank' >".$value."</a>";
    }

}

?>
