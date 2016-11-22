<?php

namespace CdiEntity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="cdi_controller")
 *
 * @author Cristian Incarnato
 */
class Controller extends \CdiEntity\Entity\BaseEntity{
    
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
     * "target_class":"CdiEntity\Entity\Entity",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="CdiEntity\Entity\Entity")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $entity;
   
    
    function getId() {
        return $this->id;
    }

    function getEntity() {
        return $this->entity;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }
    
 






}
