<?php

//AN EXAMPLE COLUMNS CONFIG

$config = [
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
        )
    ],
    "cdiEntityProperty" => [
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
        )
    ]
];

return $config;
