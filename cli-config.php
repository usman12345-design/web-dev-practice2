
<?php
require 'vendor/autoload.php';
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\DBAL\DriverManager;
use Dotenv\Dotenv;
// in next line other than this  use one of the
// Doctrine\Migrations\Configuration\Configuration\* loaders
$config = new PhpFile('migrations.php');

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$Params = [
    'dbname' => $_ENV['DB_DATABASE'] ?? 'new-wb',
    'user' => $_ENV['DB_USER'] ?? 'user',
    'password' => $_ENV['DB_PASS'] ?? 'password',
    'host' => $_ENV['DB_HOST'] ?? 'new-wb-db',
    'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
];

$ORMConfig = ORMSetup::createAttributeMetadataConfiguration(paths : [__DIR__ . "/src/Entity"],
                                                            isDevMode : true );

$connection = DriverManager::getConnection($Params,$ORMConfig);

$entityManager = new EntityManager($connection, $ORMConfig);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));

