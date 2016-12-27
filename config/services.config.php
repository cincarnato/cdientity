<?php

/**
 * User: Cristian Incarnato
 */
use Zend\ServiceManager\ServiceLocatorInterface;

return array(
    'invokables' => array(
    ),
    'factories' => array(
        'cdientity_options' => function (ServiceLocatorInterface $sm) {
            $config = $sm->get('Config');
            return new \CdiEntity\Options\CdiEntityOptions(isset($config['cdientity_options']) ? $config['cdientity_options'] : array());
        },
                'cdientity_generate_entity' => \CdiEntity\Factory\Service\CodeGeneratorFactory::class,
                'cdientity_editor' => \CdiEntity\Factory\Service\EditorFactory::class
        
        ));

        
