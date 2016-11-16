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
class Namespaces extends \CdiCommons\Entity\BaseEntity {

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
     * @Annotation\Options({"label":"Prefix:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":15}})
     * @ORM\Column(type="string", length=15, unique=false, nullable=true, name="prefix")
     */
    protected $prefix;

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
        $this->entities = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getPath() {
        return $this->path;
    }

    function getEntities() {
        return $this->entities;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function setEntities($entities) {
        $this->entities = $entities;
    }

    public function __toString() {
        return $this->name;
    }
    
    function getPrefix() {
        return $this->prefix;
    }

    function setPrefix($prefix) {
        $this->prefix = $prefix;
    }



}
