<?php

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


$databaseConfig = [
        'driver' => DB_DRIVER,
        'user' =>  DB_USER,
        'host' => DB_HOST,
        'dbname' => DB_NAME,
        'password' => DB_PASSWORD,
];

$app->register(new Silex\Provider\DoctrineServiceProvider(), [
    'db.options' => $databaseConfig
]);

$paths = [ __DIR__ . "/../src/Entity"  ];
$config = Setup::createConfiguration(!ENV_PROD);
$driver = new AnnotationDriver(new AnnotationReader(), $paths);

AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);

$app['db.em'] = EntityManager::create($databaseConfig, $config);

