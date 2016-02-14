<?php

namespace CdiEntity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="cdi_property")
 *
 * @author Cristian Incarnato
 */
class Property extends \CdiCommons\Entity\BaseEntity{
    
       /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    protected $id;
    
  
    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Cola:",
     * "empty_option": "",
     * "target_class":"CdiEntity\Entity\Entity",
     * "property": "id"})
     * @ORM\ManyToOne(targetEntity="CdiEntity\Entity\Entity")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $entity;
    
    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Name:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="name")
     */
    protected $name;
    
    
    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"TblName:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="tbl_name")
     */
    protected $tblName;
    
     /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Type:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="type")
     */
    protected $type;
    
    
    
      /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Length:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":11}})
     * @ORM\Column(type="integer", length=11, unique=false, nullable=true, name="length")
     */
    protected $length;
    
 /**
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="be_unique")
     */
    protected $beUnique;
    
     /**
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="be_nullable")
     */
    protected $beNullable;
    
    public function __construct() {
 
    }
    function getId() {
        return $this->id;
    }

    function getEntity() {
        return $this->entity;
    }

    function getName() {
        return $this->name;
    }

    function getTblName() {
        return $this->tblName;
    }

    function getType() {
        return $this->type;
    }

    function getLength() {
        return $this->length;
    }

    function getBeUnique() {
        return $this->beUnique;
    }

    function getBeNullable() {
        return $this->beNullable;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setTblName($tblName) {
        $this->tblName = $tblName;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setLength($length) {
        $this->length = $length;
    }

    function setBeUnique($beUnique) {
        $this->beUnique = $beUnique;
    }

    function setBeNullable($beNullable) {
        $this->beNullable = $beNullable;
    }

        
            

   public function __toString() {
        return $this->name;
    }






}