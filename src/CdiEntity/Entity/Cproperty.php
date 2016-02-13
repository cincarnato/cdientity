<?php

namespace CdiEntity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="cproperty")
 *
 * @author Cristian Incarnato
 */
class Cproperty extends \CdiCommons\Entity\BaseEntity{
    
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
     * "target_class":"CdiEntity\Entity\Centity",
     * "property": "id"})
     * @ORM\ManyToOne(targetEntity="CdiEntity\Entity\Centity")
     * @ORM\JoinColumn(name="conversation_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $centity;
    
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
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    protected $unique;
    
     /**
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    protected $nullable;
    
    public function __construct() {
 
    }

   

    
            

   public function __toString() {
        return $this->name;
    }






}
