<?php

namespace CdiEntity\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ControllerController extends AbstractActionController {

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
    protected $codeGenerator;

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

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiDataGrid\Grid $grid, $codeGenerator) {
        $this->em = $em;
        $this->grid = $grid;
        $this->codeGenerator = $codeGenerator;
    }

    public function abmAction() {

        $source = new \CdiDataGrid\Source\DoctrineSource($this->getEm(), '\CdiEntity\Entity\Controller');
        $this->grid->setSource($source);


        $this->grid->addExtraColumn("GENERATE", "<a class='btn btn-warning btn-xs fa fa-bars' href='/cdientity/controller/update/{{id}}' ></a>", "right", false);

        $this->grid->prepare();

        return array('grid' => $this->grid);
    }

    public function updateAction() {
        $id = $this->params("id");

        $controller = $this->getEm()->getRepository('\CdiEntity\Entity\Controller')->find($id);

        $exec = $this->codeGenerator->generateController($controller);
        $exec = $this->codeGenerator->generateControllerFactory($controller);

        return array('exec' => $exec);
    }

}
