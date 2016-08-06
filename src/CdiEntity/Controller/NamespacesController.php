<?php

namespace CdiEntity\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class NamespacesController extends AbstractActionController {

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

        $grid = $this->getServiceLocator()->get('cdiGrid');
        $source = new \CdiDataGrid\DataGrid\Source\Doctrine($this->getEntityManager(), '\CdiEntity\Entity\Namespaces');
        $grid->setSource($source);
        $grid->setRecordPerPage(20);
        $grid->datetimeColumn('createdAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('updatedAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('expiration', 'Y-m-d H:i:s');
        $grid->hiddenColumn('createdAt');
        $grid->hiddenColumn('updatedAt');
        $grid->hiddenColumn('createdBy');
        $grid->hiddenColumn('lastUpdatedBy');
        $grid->hiddenColumn('entities');

        $grid->addExtraColumn("Entities", "<a class='btn btn-warning fa fa-database' href='/cdientity/entity/abm/{{id}}#E' ></a>", "left", false);
        $grid->addEditOption("Edit", "left", "btn btn-success fa fa-edit");
        $grid->addDelOption("Del", "left", "btn btn-danger fa fa-trash");
        $grid->addNewOption("Add", "btn btn-primary fa fa-plus", " Agregar");
        $grid->setTableClass("table-condensed customClass");
        
        $grid->classTdColumn('View', "text-center col-md-1");
        $grid->classTdColumn('Edit', "text-center col-md-1");
        $grid->classTdColumn('Del', "text-center col-md-1");
         $grid->classTdColumn('Entities', "text-center col-md-1");

        $grid->prepare();
        return array('grid' => $grid);
    }

}
