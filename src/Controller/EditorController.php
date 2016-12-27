<?php

namespace CdiEntity\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EditorController extends AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Description
     * 
     * @var \CdiEntity\Service\Editor
     */
    protected $editor;

    /**
     * Some Entity
     * 
     * @var 
     */
    protected $entity;

    function getEm() {
        return $this->em;
    }

    function getGrid() {
        return $this->grid;
    }

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    function setGrid(\CdiDataGrid\Grid $grid) {
        $this->grid = $grid;
    }

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiEntity\Service\Editor $editor, $entity) {
        $this->em = $em;
        $this->editor = $editor;
        $this->entity = $entity;
    }

    public function editorAction() {
        $eid = $this->params("eid");
        $oid = $this->params("oid");
        $this->editor->process($oid);
        //TOMOVE
        $this->editor->getCrudForm()->setAttribute("class","form-horizontal");
        
        //CHECK IF SAVE AND REDIRECT TO URL WITH ID
        if($this->editor->getState() == "save"){
              return $this->redirect()->toRoute('cdi_entity_editor', ['action' => 'editor',"eid" => $eid,"oid" => $this->editor->getId()]);
        }
        
        return array('editor' => $this->editor,'entity' => $this->entity,"oid" => $oid);
    }

}
