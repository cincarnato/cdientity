<?php

namespace CdiEntity\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MainController extends AbstractActionController {

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
    
    protected $columnsConfig = [
        "createdAt" => [
                "type" => "date",
                "displayName" => "Creado en Fecha",
                "format" => "Y-m-d H:i:s"
            ],
            "updatedAt" => [
                "type" => "date",
                "displayName" => "Ultima Actualizacion",
                "format" => "Y-m-d H:i:s"
            ],
        
    ];

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

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiDataGrid\Grid $grid,$entity,$gridConfig) {
        $this->em = $em;
        $this->grid = $grid;
        $this->entity = $entity;
        $this->columnsConfig = array_merge_recursive($gridConfig["columnsConfig"], $this->columnsConfig);
    }

    public function abmAction() {

        $entity = $this->entity;

        $source = new \CdiDataGrid\Source\DoctrineSource($this->getEm(), $entity->getFullName());
        $this->grid->setSource($source);


        foreach ($entity->getProperties() as $property) {
            if ($property->getType() == "oneToMany") {
                //$grid->hiddenColumn($property->getName());
                $this->columnsConfig[$property->getName()]["hidden"] = true;
                $this->grid->addExtraColumn("<i class='fa fa-tree ' >" . $property->getName() . "</i>", "<a class='btn btn-warning fa fa-tree' href='/cdientity/main/onetomany/" . $entity->getId() . "/{{id}}/" . $property->getRelatedEntity()->getId() . "' ></a>", "right", false);
            }

            if ($property->getType() == "manyToOne" || $property->getType() == "oneToOne") {
                $filterType = new \DoctrineModule\Form\Element\ObjectSelect();

                $customData = array(
                    "eid" => $property->getRelatedEntity()->getId()
                );

                $this->columnsConfig[$property->getName()]["type"] = 'custom';
                $this->columnsConfig[$property->getName()]["helper"] = "CustomEntityLink";
                $this->columnsConfig[$property->getName()]["data"] = $customData;

                //$this->grid->customHelperColumn($property->getName(), "CustomEntityLink", $customData);
            }
            
            //echo $property->getType()." ".$property->getName();
            if ($property->getType() == "datetime") {
                $this->columnsConfig[$property->getName()]["type"] = 'datetime';
                $this->columnsConfig[$property->getName()]["format"] = 'Y-m-d H:i:s';
                //  $this->grid->datetimeColumn($property->getName(), 'Y-m-d H:i:s');
            }

            if ($property->getType() == "date") {
                $this->columnsConfig[$property->getName()]["type"] = 'datetime';
                $this->columnsConfig[$property->getName()]["format"] = 'Y-m-d';
                // $grid->datetimeColumn($property->getName(), 'Y-m-d');
            }


            if ($property->getType() == "file") {
                $this->columnsConfig[$property->getName()]["type"] = 'file';
                $this->columnsConfig[$property->getName()]["webpath"] = $property->getWebpath();
                $this->columnsConfig[$property->getName()]["width"] = "220px";
                $this->columnsConfig[$property->getName()]["height"] = "75px";
                  $this->columnsConfig[$property->getName()]["showFile"] = true;
               // $this->grid->fileColumn($property->getName(), $property->getWebpath(), "50px", "30px");
            }
        }

        $this->grid->addExtraColumn("View", "<a class='btn btn-success btn-xs fa fa-binoculars' href='/cdientity/main/view/{{id}}/" . $entity->getId() . "' ></a>", "left", false);


        $this->grid->setTemplate("default");

        //ForceFilter - TO CHECK
//        $idElement = new \Zend\Form\Element\Text("id");
//        $this->grid->addForceFilter("id", $idElement);
        
       
        //$this->grid->setColumnsConfig($this->columnsConfig);
        
        $this->grid->prepare();
        $view = new ViewModel(array('grid' => $this->grid, 'entity' => $entity));
        if ($this->getRequest()->isXmlHttpRequest()) {
            $view->setTerminal(true);
        }
        return $view;
    }

    public function viewAction() {
        //name
        $id = $this->params("id");
        //ID of Entity to filter and select
        $eid = $this->params("eid");

        $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from('CdiEntity\Entity\Entity', 'u')
                ->where("u.id = :id")
                ->setParameter("id", $eid);
        $rentity = $query->getQuery()->getOneOrNullResult();

        $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from($rentity->getFullName(), 'u')
                ->where("u.id = :id")
                ->setParameter("id", $id);
        $entity = $query->getQuery()->getOneOrNullResult();
        
        return array('entity' => $entity, 'rentity' => $rentity);
    }

    public function onetomanyAction() {

        //name
        $id = $this->params("id");
        //ID of Entity to filter and select
        $eid = $this->params("eid");
        //Related Entity
        $rid = $this->params("rid");


      
        $entity = $this->entity;


        $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from('CdiEntity\Entity\Entity', 'u')
                ->where("u.id = :id")
                ->setParameter("id", $rid);
        $rentity = $query->getQuery()->getOneOrNullResult();
        
        
           $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from($entity->getFullName(), 'u')
                ->where("u.id = :id")
                ->setParameter("id", $eid);
        $parentObject = $query->getQuery()->getOneOrNullResult();



        $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from($rentity->getFullName(), 'u')
                ->where("u." . lcfirst($entity->getName()) . " = :id")
                ->setParameter("id", $eid);


        $grid = $this->grid;
        $source = new \CdiDataGrid\Source\DoctrineSource($this->getEm(), $rentity->getFullName(), $query);
        $grid->setSource($source);


        $grid->prepare();

         $parentEntityName = lcfirst($entity->getName());
         //Remuevo la entidad padre de los filtros
         $grid->getFormFilters()->remove($parentEntityName);
        
        if ($this->request->getPost("crudAction") == "edit" || $this->request->getPost("crudAction") == "add") {
           
            $grid->getCrudForm()->remove($parentEntityName);
            $hidden = new \Zend\Form\Element\Hidden($parentEntityName);
            $hidden->setValue($eid);
            $grid->getCrudForm()->add($hidden);
        }
        
        
        


        return array('grid' => $grid, 'rentity' => $rentity,'entity' => $entity,"parentObject" => $parentObject);
    }
    
    
    
    

}
