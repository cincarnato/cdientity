<?php

namespace CdiEntity\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * @author cincarnato
 */
class CdiEntityRenderEditor extends AbstractHelper {
    /* @var $editor \CdiEntity\Service\Editor */
    protected $editor;
    
    /* @var $entity \CdiEntity\Entity\Entity */
    protected $entity;

    /**
     * Invoke helper
     *
     * Proxies to {@link render()}.
     *
     * @param  InterfaceColumn $column
     * @param  array $data
     * @return string
     */
    public function __invoke(\CdiEntity\Service\Editor $editor,\CdiEntity\Entity\Entity $entity,$oid = null) {
        $partial = "cdi-entity/partial/editor/editor";
        return $this->view->partial($partial, array("entity" => $entity,
                    "editor" => $editor,"oid" => $oid));
    }

}

?>
