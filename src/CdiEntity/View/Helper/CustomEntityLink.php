<?php

namespace CdiEntity\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use CdiDataGrid\DataGrid\Column\InterfaceColumn;

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
    public function __invoke(InterfaceColumn $column, array $data) {



        return $this->render($column, $data);
    }

    /**
     * Render a Field from the provided $column and $data
     *
     * @param  InterfaceColumn $column
     * @param  array $data
     * @return string
     */
    public function render(InterfaceColumn $column, array $data) {
        
        $value = $data[$column->getName()];
        $customData = $column->getCustomData();
        $eid = $customData["eid"];
      //  var_dump($data[$column->getName()]);
        if($data[$column->getName()]){
              $id = $data[$column->getName()]->getId();
        }
      
        
        return "<a href='/cdientity/main/view/".$id."/".$eid."' target='_blank' >".$value."</a>";
    }

}

?>
