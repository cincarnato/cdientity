<?php

namespace CdiEntity\Generator;

/**
 * Description of MenuTrait
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
Trait RepositoryTrait {

    public function generateRepository(\CdiEntity\Entity\Entity $entity) {

        $namespace = $entity->getNamespace()->getName() . "\Repository";
        $name = $namespace . "/" . $entity->getName();

        //CLASS
        $class = new \Zend\Code\Generator\ClassGenerator();
        $class->setName($entity->getName() . "Repository");

        //DOC
        $dc = new \Zend\Code\Generator\DocBlockGenerator();
        $a = array(
            array("name" => 'Repository'),
        );
        $dc->setTags($a);
        $class->setDocBlock($dc);

        //NAMESPACE
        $class->setNamespaceName($namespace);

        //USE
        $class->addUse("Doctrine\ORM\EntityRepository");

        //EXTEND
        $class->setExtendedClass("\Doctrine\ORM\EntityRepository");


        //Save Method
        $save = new \Zend\Code\Generator\MethodGenerator ( );
        //save-name
        $save->setName("save");
        //save-body
        $save->setBody(
                ' $this->getEntityManager()->persist($entity);'
                . ' $this->getEntityManager()->flush();');
        //save-parameter
        $save->setParameter("entity");
        //save-doc
        $d = new \Zend\Code\Generator\DocBlockGenerator();
        $a = [["name" => "save"]];
        $d->setTags($a);
        $save->setDocBlock($d);
        //save-add to class
        $class->addMethodFromGenerator($save);



        //remove Method
        $remove = new \Zend\Code\Generator\MethodGenerator ( );
        //remove-name
        $remove->setName("remove");
        //remove-body
        $remove->setBody(
                ' $this->getEntityManager()->remove($entity);'
                . ' $this->getEntityManager()->flush();');
        //remove-parameter
        $remove->setParameter("entity");
        //remove-doc
        $d = new \Zend\Code\Generator\DocBlockGenerator();
        $a = [["name" => "remove"]];
        $d->setTags($a);
        $remove->setDocBlock($d);
        //remove-add to class
        $class->addMethodFromGenerator($remove);


        //FILE
        $file = new \Zend\Code\Generator\FileGenerator();
        $file->setClass($class);

        // UPDATE the generated file
        try {
            $path = $entity->getNamespace()->getPath() . "/src/Repository/";
            $fileName = $entity->getNamespace()->getPath() . "/src/Repository/" . $entity->getName() . "Repository.php";


            if (!file_exists($fileName)) {

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                file_put_contents(
                        $fileName, $file->generate());
            }
        } catch (Exception $ex) {
            echo $ex;
        }
    }

}
