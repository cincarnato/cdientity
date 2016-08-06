<?php

namespace CdiEntity\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class PropertyController extends AbstractActionController {

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
        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('u')
                ->from('CdiEntity\Entity\Property', 'u')
                ->where("u.entity = :id")
                ->setParameter("id", $id);
        $entity = $this->getEntityManager()->getRepository('\CdiEntity\Entity\Entity')->find($id);
        $grid = $this->getServiceLocator()->get('cdiGrid');
        $source = new \CdiDataGrid\DataGrid\Source\Doctrine($this->getEntityManager(), '\CdiEntity\Entity\Property', $query);
        $grid->setSource($source);
        $grid->setRecordPerPage(20);
        $grid->datetimeColumn('createdAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('updatedAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('expiration', 'Y-m-d H:i:s');
        $grid->hiddenColumn('createdAt');
        $grid->hiddenColumn('updatedAt');
        $grid->hiddenColumn('createdBy');
        $grid->hiddenColumn('lastUpdatedBy');
        $grid->addEditOption("Edit", "left", "btn btn-success fa fa-edit");
        $grid->addDelOption("Del", "left", "btn btn-danger fa fa-trash");
        $grid->addNewOption("Add", "btn btn-primary fa fa-plus", " Agregar");
        
        
         $grid->classTdColumn('View', "text-center col-md-1");
        $grid->classTdColumn('Edit', "text-center col-md-1");
        $grid->classTdColumn('Del', "text-center col-md-1");
        
        $grid->setTableClass("table-condensed customClass");
        $grid->prepare();
        if ($this->request->getPost("crudAction") == "edit" || $this->request->getPost("crudAction") == "add") {
            $grid->getEntityForm()->get("entity")->setValue($id);
        }

        $options = $this->getServiceLocator()->get('cdientity_options');
        if ($options->getAutoupdate()) {
            $updateEntity = $this->getServiceLocator()->get('cdientity_generate_entity');
            $exec = $updateEntity->update($entity, true);

            if (preg_match("/Database\sschema\supdated/", $exec)) {
                $result = true;
            } else if (preg_match("/error/", $exec)) {
                $result = false;
            } else if (preg_match("/Nothing\sto\supdate/", $exec)) {
                $result = null;
            }
            $buttonPersistEnable = false;
        }else{
            $buttonPersistEnable = true;
        }


        return array('grid' => $grid, "entity" => $entity, 'exec' => $exec, 'result' => $result,'buttonPersistEnable'=>$buttonPersistEnable);
    }

}
