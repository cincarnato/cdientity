<?php

namespace CdiEntity\Service;

use \DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;

/**
 * Description of Editor
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Editor {

    /**
     * ID of OBject Entity
     *
     * @var id of object
     */
    protected $id;

    
    /**
     * State of the editor
     *
     * @var edit|save|update
     */
    protected $state;
    
    /**
     * HTTP REQUEST FROM APPLICATION-MVCEVENT
     *
     * @var \Zend\Mvc\MvcEvent
     */
    protected $mvcevent;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Datagrid Entity Name
     * 
     * @var string
     */
    protected $entityName;

    /**
     * Datagrid Entity Name
     * 
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * Form to add or edit
     * 
     * @var type
     */
    protected $form;

    /**
     * Form to add or edit
     * 
     * @var type
     */
    protected $crudForm;
    
      /**
     * Entity Object id
     */
    protected $objectId = null;
    
     /**
     * Entity Object
     */
    protected $object = null;
    
    
    
    function getId() {
        return $this->id;
    }

    function getState() {
        return $this->state;
    }

    function setId(id $id) {
        $this->id = $id;
    }

    function setState($state) {
        $this->state = $state;
    }

    
    function __construct(\Zend\Mvc\MvcEvent $mvcevent, \Doctrine\ORM\EntityManager $em) {
        $this->mvcevent = $mvcevent;
        $this->em = $em;
    }

    public function process($id = null) {
        $this->objectId = $id ;
        //IF POST... EDIT/?DELETE?
        if ($this->getMvcevent()->getRequest()->isPost()) {
            $data = $this->getMvcevent()->getRequest()->getPost();
            if ($id) {
                $result = $this->updateRecord($id, $data);
            } else {
                $result = $this->saveRecord($data);
            }
        } else {
            $this->state = "edit";
            $this->getCrudForm($id);
            $result = null;
        }
        return $result;
        //Else... Only Render Form
    }

    function getEm() {
        return $this->em;
    }

    function getEntityName() {
        return $this->entityName;
    }

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    function setEntityName($entityName) {
        $this->entityName = $entityName;
    }

    function getMvcevent() {
        return $this->mvcevent;
    }

    function setMvcevent(\Zend\Mvc\MvcEvent $mvcevent) {
        $this->mvcevent = $mvcevent;
    }

    function getForm() {
        if (!isset($this->form)) {
            $this->buildForm();
        }
        return $this->form;
    }

    function setForm($form) {
        $this->form = $form;
    }

    public function buildForm() {
        $builder = new DoctrineAnnotationBuilder($this->getEm());
        $form = $builder->createForm($this->entityName);
        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEm()));
        $this->form = $form;
    }

    public function getCrudForm($id = null) {
        if (!isset($this->crudForm)) {
            $this->crudForm = clone $this->getForm();

            if ($id) {
                $this->object = $this->getEm()->getRepository($this->entityName)->find($id);
            } else {
                $this->object = new $this->entityName;
            }

            $this->crudForm->setObject($this->object);
            $this->crudForm->setAttribute('method', 'post');
            $this->crudForm->add(array(
                'name' => 'submit',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'value' => 'submit'
                )
            ));

            $this->crudForm->bind($this->object);
        }
        return $this->crudForm;
    }

    function getRepository() {
        if (isset($this->repository)) {
            $this->setRepository($this->getEm()->getRepository($this->getEntityName()));
        }
        return $this->repository;
    }

    function setRepository(\Doctrine\ORM\EntityRepository $repository) {
        $this->repository = $repository;
        return $this;
    }

    public function delRecord($id) {
        try {
            $record = $this->getEm()->getRepository($this->entityName)->find($id);
            $this->getEm()->remove($record);
            $this->getEm()->flush();
        } catch (Exception $ex) {
            return false;
        }
        return true;
    }

    public function viewRecord($id) {
        $record = $this->getEm()->getRepository($this->entityName)->find($id);
        return $record;
    }

    public function updateRecord($id, $data) {
        $crudForm = $this->getCrudForm($id);

        $crudForm->setData($data);

        if ($crudForm->isValid()) {
            $record = $crudForm->getObject();
            //Aqui deberia crear un evento en forma de escucha
            $argv = array('record' => $record, 'form' => $crudForm, 'data' => $data);
            //   $this->getEventManager()->trigger(__FUNCTION__ . '_before', $this, $argv);
            try {
                $this->getEm()->persist($record);
                $this->getEm()->flush();
                $this->state = "update";
            } catch (Exception $ex) {
                return false;
            }
            //  $this->getEventManager()->trigger(__FUNCTION__ . '_post', $this, $argv);
            return true;
        } else {
            return false;
        }
    }

    public function saveRecord($aData) {
        $crudForm = $this->getCrudForm();

        $crudForm->setData($aData);

        if ($crudForm->isValid()) {
            $record = $crudForm->getObject();
            $argv = array('record' => $record, 'form' => $crudForm, 'data' => $aData);
            // $this->getEventManager()->trigger(__FUNCTION__ . '_before', $this, $argv);
            $this->getEm()->persist($record);
            $this->getEm()->flush();
            $argv["record"] = $record;
            $this->id = $record->getId();
            $this->state = "save";
            // $this->getEventManager()->trigger(__FUNCTION__ . '_post', $this, $argv);
            return true;
        } else {
            return false;
        }
    }
    
    function getObject() {
        return $this->object;
    }

    function setObject($object) {
        $this->object = $object;
    }

    function getObjectId() {
        return $this->objectId;
    }

    function setObjectId($objectId) {
        $this->objectId = $objectId;
    }



}
