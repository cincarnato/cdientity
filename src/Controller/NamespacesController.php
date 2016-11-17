<?php

namespace CdiEntity\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class NamespacesController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;


    /**
     * Description
     * 
     * @var \CdiDataGrid\Grid 
     */
    protected $grid;

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiDataGrid\Grid $grid) {
        $this->em = $em;
        $this->grid = $grid;
    }

    function getEm() {
        return $this->em;
    }

    function setEm(Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function abmAction() {      
        $this->grid->addExtraColumn("Entities", "<a class='btn btn-warning fa fa-database' href='/cdientity/entity/abm/{{id}}#E' ></a>", "right", false);
        $this->grid->prepare();
        return array('grid' =>  $this->grid);
    }

}
