<?php

namespace CdiEntity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="cdi_entity")
 *
 * @author Cristian Incarnato
 */
class Entity extends \CdiCommons\Entity\BaseEntity{
    
       /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    protected $id;
    
    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Namespace:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="namespace")
     */
    protected $namespace;
    
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
     * @Annotation\Options({"label":"Path:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="path")
     */
    protected $path;
    
     /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Extends:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="extends")
     */
    protected $extends;

    

    
    public function __construct() {
 
    }

    function getId() {
        return $this->id;
    }

    function getNamespace() {
        return $this->namespace;
    }

    function getName() {
        return $this->name;
    }

    function getTblName() {
        return $this->tblName;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNamespace($namespace) {
        $this->namespace = $namespace;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setTblName($tblName) {
        $this->tblName = $tblName;
    }

    function getPath() {
        return $this->path;
    }

    function getExtends() {
        return $this->extends;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function setExtends($extends) {
        $this->extends = $extends;
    }

                

   public function __toString() {
        return $this->name;
    }






}
