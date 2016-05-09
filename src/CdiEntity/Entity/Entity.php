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
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Entity:",
     * "empty_option": "",
     * "target_class":"CdiEntity\Entity\Namespaces",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="CdiEntity\Entity\Namespaces")
     * @ORM\JoinColumn(name="namespace_id", referencedColumnName="id", nullable=false,onDelete="CASCADE")
     */
    protected $namespace;
    
    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Name:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=true, nullable=true, name="name")
     */
    protected $name;
    
    
    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"TblName:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=true, nullable=true, name="tbl_name")
     */
    protected $tblName;
    
    
     /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Path & File:"})
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

    
    
    /**
     * @var 
     * @ORM\OneToMany(targetEntity="CdiEntity\Entity\Property", mappedBy="entity")
     */
    protected $properties;

    

    
    public function __construct() {
 $this->properties = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }
    
    function getFullName() {
    return $this->namespace->getName()."\\".$this->name;
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

    function getProperties() {
        return $this->properties;
    }

    function setProperties($properties) {
        $this->properties = $properties;
    }

                    

   public function __toString() {
        return $this->name;
    }


    function getNamespace() {
        return $this->namespace;
    }

    function setNamespace($namespace) {
        $this->namespace = $namespace;
    }






}
