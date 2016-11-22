<?php

namespace CdiEntity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="cdi_menu")
 *
 * @author Cristian Incarnato
 */
class Menu extends \CdiEntity\Entity\BaseEntity {

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
     * "label":"Namespace:",
     * "empty_option": "",
     * "target_class":"CdiEntity\Entity\Namespaces",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="CdiEntity\Entity\Namespaces")
     * @ORM\JoinColumn(name="namespace_id", referencedColumnName="id", nullable=false)
     */
    protected $namespace;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Entity:",
     * "empty_option": "",
     * "target_class":"CdiEntity\Entity\Entity",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="CdiEntity\Entity\Entity")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $entity;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Menu Parent:",
     * "empty_option": "",
     * "target_class":"CdiEntity\Entity\Menu",
     * "property": "label"})
     * @ORM\ManyToOne(targetEntity="CdiEntity\Entity\Menu")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id",nullable=true)
     */
    protected $parent;

    /**
     * @Annotation\Exclude()
     * @ORM\OneToMany(targetEntity="CdiEntity\Entity\Menu", mappedBy="parent")
     */
    protected $childs;

    /**
     * @var string
     * @Annotation\Options({"label":"Label:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=false)
     */
    protected $label;

    /**
     * @var string
     * @Annotation\Options({"label":"Uri:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true)
     */
    protected $uri;

    /**
     * @var string
     * @Annotation\Options({"label":"Detail:", "description": "Solo se admiten nombres alfanumericos"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true)
     */
    protected $detail;

    /**
     * @var string
     * @Annotation\Options({"label":"Icon:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true)
     */
    protected $icon;

    /**
     * @var string
     * @Annotation\Options({"label":"Permission:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=false)
     */
    protected $permission;
    
    
    public function __construct() {
        $this->childs = new ArrayCollection();
    }
    
    public function __toString() {
        return $this->label;
    }

        function getId() {
        return $this->id;
    }

    function getEntity() {
        return $this->entity;
    }

    function getLabel() {
        return $this->label;
    }

    function getUri() {
        return $this->uri;
    }

    function getDetail() {
        return $this->detail;
    }

    function getIcon() {
        return $this->icon;
    }

    function getPermission() {
        return $this->permission;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setLabel($label) {
        $this->label = $label;
    }

    function setUri($uri) {
        $this->uri = $uri;
    }

    function setDetail($detail) {
        $this->detail = $detail;
    }

    function setIcon($icon) {
        $this->icon = $icon;
    }

    function setPermission($permission) {
        $this->permission = $permission;
    }

    function getParent() {
        return $this->parent;
    }

    function setParent($parent) {
        $this->parent = $parent;
    }

    function getNamespace() {
        return $this->namespace;
    }

    function setNamespace($namespace) {
        $this->namespace = $namespace;
    }
    
    function getChilds() {
        return $this->childs;
    }

    function setChilds($childs) {
        $this->childs = $childs;
    }



}
