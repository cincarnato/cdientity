<?php

namespace CdiEntity\Generator;

/**
 * Description of MenuTrait
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
Trait EntityTrait {

    public function generateEntity(\CdiEntity\Entity\Entity $entity, $cdientity_options) {

        $namespace = $entity->getNamespace()->getName() . "\Entity";
        $class = new \Zend\Code\Generator\ClassGenerator();
        $class->setName($entity->getName());

        $dc = new \Zend\Code\Generator\DocBlockGenerator();
        $a = array(
            // array("name" => 'ORM\Entity'),
            array("name" => 'ORM\Table(name="' . $entity->getNamespace()->getPrefix() . '_' . $entity->getTblName() . '"' . $entity->getCustomOnTable() . ')'),
            array("name" => 'ORM\Entity(repositoryClass="' . $entity->getNamespace()->getName() . '\\Repository\\' . $entity->getName() . 'Repository")'),
        );
        $dc->setTags($a);
        $class->setDocBlock($dc);
        $class->setNamespaceName($namespace);
        $class->addUse("Doctrine\Common\Collections\ArrayCollection");
        $class->addUse("Zend\Form\Annotation");
        $class->addUse("Doctrine\ORM\Mapping", "ORM");
        $class->addUse("Doctrine\ORM\Mapping\UniqueConstraint", "UniqueConstraint");

        if ($entity->getExtends()) {
            $class->setExtendedClass($entity->getExtends());
        }

        //Genero campo ID
        $p = new \Zend\Code\Generator\PropertyGenerator();
        $p->setName("id");
        $d = new \Zend\Code\Generator\DocBlockGenerator();
        $a = array(
            array("name" => 'ORM\Id'),
            array("name" => 'ORM\Column(type="integer")'),
            array("name" => 'ORM\GeneratedValue(strategy="AUTO")'),
            array("name" => 'Annotation\Attributes({"type":"hidden"})'),
            array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")'),
        );
        $d->setTags($a);
        $p->setDocBlock($d);
        $mg = $this->generateGetter("id");
        $ms = $this->generateSetter("id");
        $class->addPropertyFromGenerator($p);
        $class->addMethodFromGenerator($mg);
        $class->addMethodFromGenerator($ms);

        $m = $this->generateToString("id");
        $class->addMethodFromGenerator($m);

        $toString = true;
        foreach ($entity->getProperties() as $property) {

            //Si no es del tipo File
            if (($property->getType() == "oneToOne" || $property->getType() == "manyToOne") && $property->getRelatedEntity() == null) {
                return "<div class='alert alert-danger'> Una Property de tipo " . $property->getType() . " debe tener una Entidad relacionada</div>";
            }
            //Propertie
            $p = new \Zend\Code\Generator\PropertyGenerator();
            $p->setName($property->getName());

            if ($toString == true && $property->getType() == "string") {
                $class->removeMethod("__toString");
                $m = $this->generateToString($property->getName());
                $class->addMethodFromGenerator($m);
                $toString = false;
            }

            //DocBlock
            $d = $this->generateDoc($property, $entity);
            $p->setDocBlock($d);

            //Getter
            $mg = $this->generateGetter($property->getName());

            //Setter
            if ($property->getType() == "file") {
                $ms = $this->generateSetterFile($property->getName());
            } else {
                $ms = $this->generateSetter($property->getName());
            }

            //Asign
            $class->addPropertyFromGenerator($p);
            $class->addMethodFromGenerator($mg);
            $class->addMethodFromGenerator($ms);

            //Metodos auxiliares para File

            if ($property->getType() == "file") {
                $a = $this->generateFileMethods($property);
                $class->addMethods($a);
            }
        }



        $file = new \Zend\Code\Generator\ FileGenerator();
        $file->setClass($class);

        // UPDATE the generated file
        $this->updateFile($entity, $file->generate());

        //GENERATE REPOSITORY
        $this->generateRepository($entity);


        if ($cdientity_options->getAutoupdate()) {
            return exec($cdientity_options->getScriptUpdateSchema());
        } else {
            return "NA";
        }
    }

    protected function toArray() {
        $mg = new \Zend\Code\Generator\MethodGenerator();

        $mg->setName("toArray");
        $mg->setBody('return (array) $this;');
        return $mg;
    }

    public function updateFile($entity, $file_contents) {
        try {
            $file = $entity->getNamespace()->getPath() . "/src/Entity/" . $entity->getName() . ".php";

            file_put_contents(
                    $file, $file_contents);
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    protected function generateDoc($property, $entity) {

        if ($property->getLabel()) {
            $label = $property->getLabel();
        } else {
            $label = $property->getName();
        }


        switch ($property->getType()) {

            case "string":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"text"})'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '", "description":"' . $property->getDescription() . '"})')
                    );
                }

                $aDoctrine = array(
                    array("name" => 'ORM\Column(type="string", length=' . $property->getLength() . ', unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $this->camelToUnder($property->getName()) . '")')
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "stringarea":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"textarea"})'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '", "description":"' . $property->getDescription() . '"})')
                    );
                }

                $aDoctrine = array(
                    array("name" => 'ORM\Column(type="string", length=' . $property->getLength() . ', unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $this->camelToUnder($property->getName()) . '")')
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "date":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Type("Zend\Form\Element\Date")'),
                        array("name" => 'Annotation\Attributes({"type":"date"})'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '", "description":"' . $property->getDescription() . '"})')
                    );
                }

                $aDoctrine = array(
                    array("name" => 'ORM\Column(type="date", unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $this->camelToUnder($property->getName()) . '")')
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "datetime":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Type("Zend\Form\Element\Date")'),
                        array("name" => 'Annotation\Attributes({"type":"datetime"})'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '", "description":"' . $property->getDescription() . '"})')
                    );
                }

                $aDoctrine = array(
                    array("name" => 'ORM\Column(type="datetime", unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $this->camelToUnder($property->getName()) . '")')
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "time":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Type("Zend\Form\Element\Time")'),
                        array("name" => 'Annotation\Attributes({"type":"time"})'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '", "description":"' . $property->getDescription() . '"})')
                    );
                }

                $aDoctrine = array(
                    array("name" => 'ORM\Column(type="time", unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $this->camelToUnder($property->getName()) . '")')
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "integer":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"text"})'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '", "description":"' . $property->getDescription() . '"})'),
                    );
                }

                $aDoctrine = array(
                    array("name" => 'ORM\Column(type="integer", length=' . $property->getLength() . ', unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $this->camelToUnder($property->getName()) . '")'),
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "decimal":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"text"})'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '", "description":"' . $property->getDescription() . '"})'),
                    );
                }

                $aDoctrine = array(
                    array("name" => 'ORM\Column(type="decimal", scale=2, precision=' . $property->getLength() . ', unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $this->camelToUnder($property->getName()) . '")'),
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "text":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"textarea"})'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '", "description":"' . $property->getDescription() . '"})'),
                    );
                }

                $aDoctrine = array(
                    array("name" => 'ORM\Column(type="text", unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $this->camelToUnder($property->getName()) . '")'),
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "boolean":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Type("Zend\Form\Element\Checkbox")'),
                        array("name" => 'Annotation\Attributes({"type":"checkbox"})'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '", "description":"' . $property->getDescription() . '"})')
                    );
                }

                if ($property->getBeNullable()) {
                    $aForm[] = array("name" => 'Annotation\AllowEmpty({"true"}) ');
                }

                $aDoctrine = array(
                    array("name" => 'ORM\Column(type="boolean", nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . strtolower($property->getName()) . '")'),
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "file":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Type("Zend\Form\Element\File")'),
                        array("name" => 'Annotation\Attributes({"type":"file"})'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '","absolutepath":"' . $property->getAbsolutepath() . '","webpath":"' . $property->getWebpath() . '", "description":"' . $property->getDescription() . '"})'),
                        array("name" => 'Annotation\Filter({"name":"filerenameupload", "options":{"target":"' . $property->getAbsolutepath() . '","use_upload_name":1,"overwrite":1}})'),
                    );
                }

                $aDoctrine = array(
                    array("name" => 'ORM\Column(type="string", length=' . $property->getLength() . ', unique=' . $this->booleanString($property->getBeUnique()) . ', nullable=' . $this->booleanString($property->getBeNullable()) . ', name="' . $this->camelToUnder($property->getName()) . '")'),
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "oneToOne":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '","empty_option": "","target_class":"' . $property->getRelatedEntity()->getFullName() . '", "description":"' . $property->getDescription() . '"})'),
                    );
                }

                $aDoctrine = array(
                    array("name" => 'ORM\OneToOne(targetEntity="' . $property->getRelatedEntity()->getFullName() . '")'),
                    array("name" => 'ORM\JoinColumn(name="' . $this->camelToUnder($property->getName()) . '_id", referencedColumnName="id"' . ($property->getBeNullable() ? ', nullable=true' : ', nullable=false') . ')')
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "manyToOne":
                $d = new \Zend\Code\Generator\DocBlockGenerator();

                if ($property->getExclude()) {
                    $aForm = array(
                        array("name" => 'Annotation\Exclude()')
                    );
                } else if ($property->getHidden()) {
                    $aForm = array(
                        array("name" => 'Annotation\Attributes({"type":"hidden"})'),
                        array("name" => 'Annotation\Type("Zend\Form\Element\Hidden")')
                    );
                } else {
                    $aForm = array(
                        array("name" => 'Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")'),
                        array("name" => 'Annotation\Options({"label":"' . $label . '","empty_option": "' . $property->getRelatedEntity()->getName() . '","target_class":"' . $property->getRelatedEntity()->getFullName() . '", "description":"' . $property->getDescription() . '"})'),
                    );
                }

                $aDoctrine = array(
                    array("name" => 'ORM\ManyToOne(targetEntity="' . $property->getRelatedEntity()->getFullName() . '")'),
                    array("name" => 'ORM\JoinColumn(name="' . $this->camelToUnder($property->getName()) . '_id", referencedColumnName="id"' . ($property->getBeNullable() ? ', nullable=true' : ', nullable=false') . ')')
                );

                $a = array_merge_recursive($aForm, $aDoctrine);

                $d->setTags($a);
                break;
            case "oneToMany":

                $d = new \Zend\Code\Generator\DocBlockGenerator();
                //Debo remplazar strtolower($entity->getName()) por una busqueda de la propiedad que tiene la relacion
                $a = array(
                    array("name" => 'Annotation\Exclude()'),
                    array("name" => 'ORM\OneToMany(targetEntity="' . $property->getRelatedEntity()->getFullName() . '", mappedBy="' . lcfirst($entity->getName()) . '")'),
                );
                $d->setTags($a);
                break;
            case "manyToMany":

                $d = new \Zend\Code\Generator\DocBlockGenerator();

                $a = array(
                    array("name" => 'Annotation\Exclude()'),
                    array("name" => 'ORM\ManyToMany(targetEntity="' . $property->getRelatedEntity()->getFullName() . '")'),
                );
                $d->setTags($a);
                break;
        }

        //Mandatorio
        if ($property->getMandatory()) {
            $aRequire = array(
                array("name" => 'Annotation\Required(true)'),
                array("name" => 'Annotation\Validator({"name":"NotEmpty"})')
            );
            $d->setTags($aRequire);
        }

        return $d;
    }

    protected function generateSetterFile($name) {
        $ms = new \Zend\Code\Generator\MethodGenerator ( );
        $ms->setName("set" . ucfirst($name));
        $ms->setBody(
                'if(is_array($' . $name . ')){'
                . '$this->' . $name . " = $" . $name . "['name'];"
                . "}else{"
                . '$this->' . $name . " = $" . $name . ";"
                . "}");
        $ms->setParameter($name);
        return $ms;
    }

    protected function generateFileMethods($property) {
        $ma = new \Zend\Code\Generator\MethodGenerator ( );
        $method = "get" . ucfirst($property->getName()) . "_ap";
        $ma->setName($method);
        $ma->setBody('return "' . $property->getAbsolutepath() . '";');
        $a[] = $ma;


        $ms = new \Zend\Code\Generator\MethodGenerator ( );
        $method = "get" . ucfirst($property->getName()) . "_wp";
        $ms->setName($method);
        $ms->setBody('return "' . $property->getWebpath() . '";');
        $a[] = $ms;

        $mf = new \Zend\Code\Generator\MethodGenerator ( );
        $method = "get" . ucfirst($property->getName()) . "_fp";
        $mf->setName($method);
        $mf->setBody('return "' . $property->getWebpath() . '".$this->' . $property->getName() . ';');
        $a[] = $mf;

        return $a;
    }

    protected function generateToString($name) {
        $m = new \Zend\Code\Generator\MethodGenerator ( );
        $m->setName(
                "__toString");
        $m->setBody('return (string) $this->' . $name . ";");
        return $m;
    }

    protected function booleanString($value) {
        if ($value) {
            return "true";
        } else {
            return "false";
        }
    }

    protected function camelToUnder($input) {
        $output = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $input)), '_');
        return $output;
    }

}
