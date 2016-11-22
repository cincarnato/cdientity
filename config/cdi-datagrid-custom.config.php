<?php

//AN EXAMPLE COLUMNS CONFIG

$config = [
    "cdiEntityController" => [
        "sourceConfig" => [
            "type" => "doctrine",
            "doctrineOptions" => [
                "entityName" => "\CdiEntity\Entity\Controller",
                "entityManager" => "Doctrine\ORM\EntityManager"
            ]
        ],
        "columnsConfig" => array(
            "createdAt" => [
                "type" => "date",
                "displayName" => "Creado en Fecha",
                "format" => "Y-m-d H:i:s",
                 "hidden" => true
            ],
            "updatedAt" => [
                "type" => "date",
                "displayName" => "Ultima Actualizacion",
                "format" => "Y-m-d H:i:s",
                 "hidden" => true
            ],
            "childs" => [
                "hidden" => true
            ],
        )
    ],
    "cdiEntityMenu" => [
        "sourceConfig" => [
            "type" => "doctrine",
            "doctrineOptions" => [
                "entityName" => "\CdiEntity\Entity\Menu",
                "entityManager" => "Doctrine\ORM\EntityManager"
            ]
        ],
        "columnsConfig" => array(
            "createdAt" => [
                "type" => "date",
                "displayName" => "Creado en Fecha",
                "format" => "Y-m-d H:i:s",
                 "hidden" => true
            ],
            "updatedAt" => [
                "type" => "date",
                "displayName" => "Ultima Actualizacion",
                "format" => "Y-m-d H:i:s",
                 "hidden" => true
            ],
            "childs" => [
                "hidden" => true
            ],
              "parent" => [
                "type" => "relational"
            ],
        )
    ],
    "cdiEntityNamespace" => [
        "sourceConfig" => [
            "type" => "doctrine",
            "doctrineOptions" => [
                "entityName" => "\CdiEntity\Entity\Namespaces",
                "entityManager" => "Doctrine\ORM\EntityManager"
            ]
        ],
        "columnsConfig" => array(
            "createdAt" => [
                "type" => "date",
                "displayName" => "Creado en Fecha",
                "format" => "Y-m-d H:i:s"
            ],
            "updatedAt" => [
                "type" => "date",
                "displayName" => "Ultima Actualizacion",
                "format" => "Y-m-d H:i:s"
            ],
            "entities" => [
                "hidden" => true
            ],
            "path" => [
                "hidden" => true
            ],
             "Entities" => [
                "tdClass" => "text-center"
            ]
        )
    ],
    "cdiEntityEntity" => [
        "columnsConfig" => array(
            "createdAt" => [
                "type" => "date",
                "displayName" => "Creado en Fecha",
                "format" => "Y-m-d H:i:s"
            ],
            "updatedAt" => [
                "type" => "date",
                "displayName" => "Ultima Actualizacion",
                "format" => "Y-m-d H:i:s"
            ],
            "properties" => [
                "hidden" => true
            ],
            "extends" => [
                "hidden" => true
            ],
            "customOnTable" => [
                "hidden" => true
            ],
            "tblName" => [
                "hidden" => true
            ],
            "ABM" => [
                "tdClass" => "text-center"
            ],
             "Properties" => [
                "tdClass" => "text-center"
            ]
        )
    ],
    "cdiEntityProperty" => [
        "columnsConfig" => array(
            "createdAt" => [
                "type" => "date",
                "displayName" => "Creado en Fecha",
                "format" => "Y-m-d H:i:s",
                   "hidden" => true
            ],
            "updatedAt" => [
                "type" => "date",
                "displayName" => "Ultima Actualizacion",
                "format" => "Y-m-d H:i:s",
                   "hidden" => true
            ],
            "absolutepath" => [
                "hidden" => true
            ],
            "webpath" => [
                "hidden" => true
            ],
            "description" => [
                "hidden" => true
            ],
            "label" => [
                "hidden" => true
            ],
            "exclude" => [
                "hidden" => true
            ],
        )
    ]
];

return $config;
