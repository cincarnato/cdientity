<?php

namespace CdiEntity\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class MenuController extends AbstractActionController {

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

        $source = new \CdiDataGrid\Source\DoctrineSource($this->getEm(), '\CdiEntity\Entity\Menu');
        $this->grid->setSource($source);


        //$this->grid->addExtraColumn("Properties", "<a class='btn btn-warning btn-xs fa fa-bars' href='/cdientity/property/abm/{{id}}#E' ></a>", "right", false);

        $this->grid->prepare();

        return array('grid' => $this->grid);
    }

    public function updateAction() {

        $menus = $this->getEm()->getRepository('\CdiEntity\Entity\Menu')->findBy(["parent" => null]);

        foreach ($menus as $menu) {
            $nms[$menu->getNamespace()->getId()]["nm"] = $menu->getNamespace();
            $nms[$menu->getNamespace()->getId()]["menus"][] = $menu;
        }

        foreach ($nms as $nm) {
            $exec = $this->codeGenerator->generateMenu($nm["nm"], $nm["menus"]);
        }


        return array('exec' => $exec);
    }

}
