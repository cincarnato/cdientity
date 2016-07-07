<?php

namespace CdiEntity\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class EntityController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

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
        if ($id) {
            $query = $this->getEntityManager()->createQueryBuilder()
                    ->select('u')
                    ->from('CdiEntity\Entity\Entity', 'u')
                    ->where("u.namespace = :id")
                    ->setParameter("id", $id);
        } else {
            $query = $this->getEntityManager()->createQueryBuilder()
                    ->select('u')
                    ->from('CdiEntity\Entity\Entity', 'u');
        }


        $grid = $this->getServiceLocator()->get('cdiGrid');
        $source = new \CdiDataGrid\DataGrid\Source\Doctrine($this->getEntityManager(), '\CdiEntity\Entity\Entity', $query);
        $grid->setSource($source);
        $grid->setRecordPerPage(20);
        $grid->datetimeColumn('createdAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('updatedAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('expiration', 'Y-m-d H:i:s');
        $grid->hiddenColumn('createdAt');
        $grid->hiddenColumn('updatedAt');
        $grid->hiddenColumn('createdBy');
        $grid->hiddenColumn('lastUpdatedBy');
         $grid->hiddenColumn('properties');

        $grid->addExtraColumn("<i class='fa fa-bars ' ></i>", "<a class='btn btn-warning fa fa-bars' href='/cdientity/property/abm/{{id}}#E' ></a>", "left", false);
        $grid->addExtraColumn("<i class='fa fa-book ' ></i>", "<a class='btn btn-primary fa fa-book' href='/cdientity/main/abm/{{id}}' ></a>", "left", false);
        $grid->addEditOption("Edit", "left", "btn btn-success fa fa-edit");
        $grid->addDelOption("Del", "left", "btn btn-warning fa fa-trash");
        $grid->addNewOption("Add", "btn btn-primary fa fa-plus", " Agregar");
        $grid->setTableClass("table-condensed customClass");

        $grid->prepare();

        if ($this->request->getPost("crudAction") == "edit" || $this->request->getPost("crudAction") == "add") {
            $grid->getEntityForm()->get("namespace")->setValue($id);
        }

        return array('grid' => $grid);
    }

    public function updateAction() {
        $id = $this->params("id");

        $entity = $this->getEntityManager()->getRepository('\CdiEntity\Entity\Entity')->find($id);

        $updateEntity = $this->getServiceLocator()->get('cdientity_generate_entity');
        $exec = $updateEntity->update($entity, true);

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
