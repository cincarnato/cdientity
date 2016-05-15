<?php

namespace CdiEntity\Options;

use Zend\Stdlib\AbstractOptions;

class CdiEntityOptions extends AbstractOptions {

    protected $scriptUpdateSchema;
    protected $autoupdate;

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

    function getAutoupdate() {
        return $this->autoupdate;
    }

    function setAutoupdate($autoupdate) {
        $this->autoupdate = $autoupdate;
    }

}
