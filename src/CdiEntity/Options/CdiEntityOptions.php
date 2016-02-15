<?php

namespace CdiEntity\Options;

use Zend\Stdlib\AbstractOptions;

class CdiEntityOptions extends AbstractOptions {

    protected $scriptUpdateSchema;

    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    function getScriptUpdateSchema() {
        return $this->scriptUpdateSchema;
    }

    function setScriptUpdateSchema($scriptUpdateSchema) {
        $this->scriptUpdateSchema = $scriptUpdateSchema;
    }

}
