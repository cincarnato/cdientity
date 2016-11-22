<?php

namespace CdiEntity\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class EntityController extends AbstractActionController {

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
     * Description
     * 
     * @var \CdiEntity\Options\CdiEntityOptions
     */
    protected $options;
    
       /**
     * Description
     * 
     * @var \CdiEntity\Service\CodeGenerator
     */
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

    function getOptions() {
        return $this->options;
    }

 
    function setOptions(\CdiEntity\Options\CdiEntityOptions $options) {
        $this->options = $options;
    }

    function getCodeGenerator() {
        return $this->codeGenerator;
    }

    function setCodeGenerator(\CdiEntity\Service\CodeGenerator $codeGenerator) {
        $this->codeGenerator = $codeGenerator;
    }

       

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiDataGrid\Grid $grid, \CdiEntity\Options\CdiEntityOptions $options, $codeGenerator) {
        $this->setEm($em);
        $this->setGrid($grid);
        $this->setOptions($options);
        $this->setCodeGenerator($codeGenerator);
    }

    public function abmAction() {

        $id = $this->params("id");
        if ($id) {
            $query = $this->getEm()->createQueryBuilder()
                    ->select('u')
                    ->from('\CdiEntity\Entity\Entity', 'u')
                    ->where("u.namespace = :id")
                    ->setParameter("id", $id);
        } else {
            $query = $this->getEm()->createQueryBuilder()
                    ->select('u')
                    ->from('\CdiEntity\Entity\Entity', 'u');
        }


        $source = new \CdiDataGrid\Source\DoctrineSource($this->getEm(), '\CdiEntity\Entity\Entity', $query);
        $this->grid->setSource($source);



        $this->grid->addExtraColumn("Properties", "<a class='btn btn-warning btn-xs fa fa-bars' href='/cdientity/property/abm/{{id}}#E' ></a>", "right", false);
        $this->grid->addExtraColumn("ABM", "<a class='btn btn-primary btn-xs fa fa-book' href='/cdientity/main/abm/{{id}}' ></a>", "right", false);


        $this->grid->prepare();

        if ($this->request->getPost("crudAction") == "edit" || $this->request->getPost("crudAction") == "add") {
            $this->grid->getSource()->getCrudForm()->get("namespace")->setValue($id);
        }

        return array('grid' => $this->grid);
    }

    public function updateAction() {
        $id = $this->params("id");

        $entity = $this->getEm()->getRepository('\CdiEntity\Entity\Entity')->find($id);

        $exec = $this->codeGenerator->generateEntity($entity, $this->getOptions());

        if (preg_match("/Database\sschema\supdated/", $exec)) {
            $result = true;
        } else if (preg_match("/error/", $exec)) {
            $result = false;
        } else if (preg_match("/Nothing\sto\supdate/", $exec)) {
            $result = null;
        }
        return array('exec' => $exec);
    }

}
