<?php

error_reporting(E_ALL);
ini_set('display_start_errors',1);
ini_set('display_errors',1);


require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("Entity");
$isDevMode = true;

$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'database',
    'host' => 'db'
);


$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$conn = $entityManager->getConnection();

// exclude any tables here
$conn->getConfiguration()->setFilterSchemaAssetsExpression('~^(?!TableName)~');
