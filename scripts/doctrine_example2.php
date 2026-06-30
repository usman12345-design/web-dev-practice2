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
//where amount > :amount and (status = :status OR created_at >= :date)
//if we write where second time then second times where will overwrite firstone
//but we can  ->andWhere('i.status = :status')->orWhere('i.createdAt = :date') result as
//WHERE (i0_.amount > ? AND i0_.status = ?) OR i0_.created_at = ? which is different
$queryBuilder = $entityManager->createQueryBuilder();
$query=$queryBuilder->select('i','it')
              ->from(invoices::class, 'i')
                ->join('i.items', 'it')
              ->where(
                      $queryBuilder->expr()->andX(
                          $queryBuilder->expr()->gt( 'i.amount',':amount'),
                          $queryBuilder->expr()->orX(
                              $queryBuilder->expr()->eq ('i.status',':status'),
                             $queryBuilder->expr()->gte('i.createdAt',':date'),
                          )
                      )
              )
           ->setParameter('amount', 43)
            ->setParameter('status',InvoiceStatus::PAID->value )
            ->setParameter('date', '2026-06-29 00:00:00')
           ->orderBy('i.createdAt', 'ASC')
           ->getQuery();
//echo $query->getSQL();
$result = $query->getResult();  // gives array if we are specific in select otherwise whole entity
//$result = $query->getArrayResult();
//var_dump($result);



foreach ($result as $invoice) {
    echo $invoice->getCreatedAt()->format('m/d/y g:ia') . "\n".
        $invoice->getAmount() . "\n";
    foreach ($invoice->getItems() as $item) {
        echo $item->getDescription() . "\n".
            $item->getQuantity() . "\n".
            $item->getUnitPrice() . "\n";
    }
}

//life cycle events
//pre entity persist
//pre/post entity remove
//pre/post entity flush