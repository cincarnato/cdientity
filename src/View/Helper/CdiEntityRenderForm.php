<?php

namespace CdiEntity\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author cincarnato
 */
class CdiEntityRenderForm extends AbstractHelper {

    public function __invoke($form,$templateForm, $templateElement) {

        $partial = 'cdi-entity/forms/' . $templateForm;
        $partialElement = 'cdi-entity/forms/elements/' . $templateElement;

        return $this->view->partial($partial, array("form" => $form,
                    "partialElement" => $partialElement));
    }

}

?>
