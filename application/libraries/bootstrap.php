<?php
/**
 * Doctrine boostrap file for CodeIgniter
 */

use Doctrine\Common\ClassLoader,
    Doctrine\Common\Cache\ArrayCache,
    Doctrine\Common\Annotations\AnnotationRegistry,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ORM\Tools\Setup,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\Mapping\Driver\AnnotationDriver;

$PATH_APP = dirname(__DIR__);
$PATH_DOCTRINE = 'Doctrine';

include $PATH_APP . '/config/database.php';
require_once $PATH_DOCTRINE . '/Common/ClassLoader.php';

$doctrineClassLoader = new ClassLoader('Doctrine', __DIR__);
$doctrineClassLoader->register();

// Replace it with your environment
$applicationMode = 'development';

$isDevMode = FALSE;
$paths = array(APPPATH . '/models');
$cacheImpl = $applicationMode == 'development' ? new ArrayCache : new Doctrine\Common\Cache\ApcCache;

// Configuration
$config = Setup::createConfiguration($isDevMode);
$driver = new AnnotationDriver(new AnnotationReader(), $paths);
 $models_namespace = 'Entities';
        $models_path = APPPATH . 'models';
        $proxies_dir = APPPATH . 'models/Proxies';
        $metadata_paths = array(APPPATH . 'models');

        // Set $dev_mode to TRUE to disable caching while you develop
        $config = Setup::createAnnotationMetadataConfiguration($metadata_paths, $dev_mode = true, $proxies_dir);
        $loader = new ClassLoader($models_namespace, $models_path);
        $loader->register();
// Registering noop annotation autoloader - allow all annotations by default
AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);
$config->setMetadataCacheImpl($cacheImpl);
$config->setQueryCacheImpl($cacheImpl);

$conn = array(
    'host' => $db['default']['hostname'],
    'driver' => 'pdo_mysql',
    'user' => $db['default']['username'],
    'password' => $db['default']['password'],
    'dbname' => $db['default']['database'],
    'charset' => $db['default']['char_set'],
);

$entityManager = EntityManager::create($conn, $config);