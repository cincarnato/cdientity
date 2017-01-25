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
     * @var \Doctrine\ORM\EntityManager
     */
    protected $emCdiEntity;

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
    
    function getEmCdiEntity() {
        return $this->emCdiEntity;
    }

    function setEmCdiEntity(\Doctrine\ORM\EntityManager $emCdiEntity) {
        $this->emCdiEntity = $emCdiEntity;
    }

    
    function __construct(\Doctrine\ORM\EntityManager $em,\Doctrine\ORM\EntityManager $emCdiEntity, \CdiEntity\Service\Editor $editor, $entity) {
        $this->em = $em;
        $this->editor = $editor;
        $this->entity = $entity;
        $this->emCdiEntity = $emCdiEntity;
    }

    public function editorAction() {
        $eid = $this->params("entityId");
        $oid = $this->params("objectId");
        $this->editor->process($oid);

        //TOMOVE
        $this->editor->getCrudForm()->setAttribute("class","form-horizontal");
        
        //CHECK IF SAVE AND REDIRECT TO URL WITH ID
        if($this->editor->getState() == "save"){
              return $this->redirect()->toRoute('cdi_entity_editor', ['action' => 'editor',"entityId" => $eid,"objectId" => $this->editor->getId()]);
        }
        
        return array('editor' => $this->editor,'entity' => $this->entity,"oid" => $oid);
    }

}
