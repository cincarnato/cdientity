<?php

namespace CdiEntity\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class PropertyController extends AbstractActionController {

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
    protected $options;
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
        $this->grid = $this->grid;
    }

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiDataGrid\Grid $grid, \CdiEntity\Service\CodeGenerator $codeGenerator,$options) {
        $this->em = $em;
        $this->grid = $grid;
        $this->options = $options;
        $this->codeGenerator = $codeGenerator;
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
        $id = $this->params("id");

        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('u')
                ->from('\CdiEntity\Entity\Property', 'u')
                ->where("u.entity = :id")
                ->setParameter("id", $id);
        $entity = $this->getEntityManager()->getRepository('\CdiEntity\Entity\Entity')->find($id);

        $source = new \CdiDataGrid\Source\DoctrineSource($this->getEntityManager(), '\CdiEntity\Entity\Property', $query);
        $this->grid->setSource($source);


        $this->grid->prepare();


        if ($this->request->getPost("crudAction") == "edit" || $this->request->getPost("crudAction") == "add") {
            $this->grid->getSource()->getCrudForm()->get("entity")->setValue($id);
        }




        return array('grid' => $this->grid, "entity" => $entity);
    }

}
