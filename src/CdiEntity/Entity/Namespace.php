<?php

namespace CdiEntity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="cdi_namespaces")
 *
 * @author Cristian Incarnato
 */
class Namespaces extends \CdiCommons\Entity\BaseEntity{
    
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
    protected $name;
    
    
     /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Path & File:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="path")
     */
    protected $path;

    
    
    /**
     * @var 
     * @ORM\OneToMany(targetEntity="CdiEntity\Entity\Entity", mappedBy="namespaces")
     */
    protected $entities;

    

    
    public function __construct() {
 $this->properties = new ArrayCollection();
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

    function getProperties() {
        return $this->properties;
    }

    function setProperties($properties) {
        $this->properties = $properties;
    }

                    

   public function __toString() {
        return $this->name;
    }






}
