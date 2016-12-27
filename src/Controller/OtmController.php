<?php

namespace CdiEntity\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OtmController extends AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Description
     * 
     * @var \CdiDataGrid\Grid 
     */
    protected $grid;
    
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

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiDataGrid\Grid $grid, $entity) {
        $this->em = $em;
        $this->grid = $grid;
        $this->entity = $entity;
    }

    public function ajaxAction() {

        //ID de Entidad
        $entityId= $this->params("entityId");
        //ID del Objeto Padre en si mismo
        $parentObjectId = $this->params("parentObjectId");
        //ID de la Entidad Padre (oneToMany) del objeto padre
        $parentEntityId = $this->params("parentEntityId");


      
        $entity = $this->entity;


        $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from('CdiEntity\Entity\Entity', 'u')
                ->where("u.id = :id")
                ->setParameter("id", $parentEntityId);
        $parentEntity = $query->getQuery()->getOneOrNullResult();
        
        
           $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from($entity->getFullName(), 'u')
                ->where("u.id = :id")
                ->setParameter("id", $parentObjectId);
        $parentObject = $query->getQuery()->getOneOrNullResult();



        $gridQuery = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from($entity->getFullName(), 'u')
                ->where("u." . lcfirst($parentEntity->getName()) . " = :id")
                ->setParameter("id", $parentObjectId);


        $grid = $this->grid;
        $source = new \CdiDataGrid\Source\DoctrineSource($this->getEm(), $entity->getFullName(), $gridQuery);
        $grid->setSource($source);

        $grid->setTemplate("ajax");
        $grid->setId("cdiGrid_".$entity->getName());
        $grid->prepare();

         $parentEntityName = lcfirst($parentEntity->getName());
         //Remuevo la entidad padre de los filtros
         $grid->getFormFilters()->remove($parentEntityName);
        
        if ($this->request->getPost("crudAction") == "edit" || $this->request->getPost("crudAction") == "add") {
           
            $grid->getCrudForm()->remove($parentEntityName);
            $hidden = new \Zend\Form\Element\Hidden($parentEntityName);
            $hidden->setValue($parentObjectId);
            $grid->getCrudForm()->add($hidden);
        }
        
        
        

       $view = new ViewModel(array('grid' => $grid, 'parentEntity' => $parentEntity,'entity' => $entity,"parentObject" => $parentObject));
     $view->setTerminal(true);
     return $view;
    }

}
