<?php
declare(strict_types=1);
use App\Entity\invoiceItems;
use App\Entity\invoices;
use App\Enums\InvoiceStatus;
use Dotenv\Dotenv;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$Params = [
    'dbname' => $_ENV['DB_DATABASE'] ?? 'new-wb',
    'user' => $_ENV['DB_USER'] ?? 'user',
    'password' => $_ENV['DB_PASS'] ?? 'password',
    'host' => $_ENV['DB_HOST'] ?? 'new-wb-db',
    'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
];

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . "/../src/Entity"],
    isDevMode: true
);

$connection = DriverManager::getConnection($Params, $config);
$entityManager = new EntityManager($connection, $config);

//items = [['item4', 4, 15],['item5', 5, 7.5],['item6', 6, 75]];
//invoice = (new invoices())
//           ->setAmount(42)
//           ->setInvoiceNumber('2')
//           ->setStatus(InvoiceStatus::PENDING)
//           ->setCreatedAt(new \DateTime());
//
//foreach ($items as [$description, $quantity, $unitPrice]) {
//   $item = (new invoiceItems())
//           ->setDescription($description)
//           ->setQuantity($quantity)
//           ->setUnitPrice($unitPrice);
//   $invoice->addItems($item);
//}
$invoice = $entityManager->find(invoices::class, 3);
if ($invoice === null) {

    die("Error: Invoice with ID 3 was not found in the database!\n");
}
$invoice->getItems()->get(0)->setDescription('foo bar');

 //$invoice->setStatus(InvoiceStatus::PAID);
//$entityManager->persist($invoice);
$entityManager->flush();


echo "Database transaction completed successfully!\n";
echo $entityManager->getUnitOfWork()->size();