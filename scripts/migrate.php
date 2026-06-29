<?php

// 1. REQUIRE COMPOSER AUTOLOADER (Tells PHP where to find Doctrine classes)
require_once __DIR__ . '/../vendor/autoload.php';

// 2. BOOTSTRAP YOUR APP DATABASE CONNECTION
// Assuming your database connection wrapper or configuration is initialized in an app file,
// require that file here so $conn is defined and populated:
$config = require __DIR__ . '/../src/config.php'; // Update this path to match your actual config/bootstrap file path
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\DriverManager;
$connectionParams = [
               'dbname' => $_ENV['DB_DATABASE'] ?? 'new-wb',
                'user' => $_ENV['DB_USER'] ?? 'user',
                'password' => $_ENV['DB_PASS'] ?? 'password',
                'host' => $_ENV['DB_HOST'] ?? 'new-wb-db',
                'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
];

// 2. EXPLICITLY CREATE THE $conn VARIABLE
$conn = DriverManager::getConnection($connectionParams);

// 1. Initialize a clean, empty Schema object
$schema = new Schema();

// ==========================================
// 2. BUILD THE INVOICES TABLE
// ==========================================
$invoicesTable = $schema->createTable('invoices');

// Primary Auto-Increment Key
$invoicesTable->addColumn('id', Types::INTEGER, ['unsigned' => true, 'autoincrement' => true]);
// Invoice Specific Fields
$invoicesTable->addColumn('invoice_number', Types::STRING, ['length' => 50]);
$invoicesTable->addColumn('amount', Types::DECIMAL, ['precision' => 10, 'scale' => 2, 'default' => 0.00]);
$invoicesTable->addColumn('status', Types::SMALLINT, ['default' => 0]); // E.g., Using your Enum values
// Timestamps
$invoicesTable->addColumn('created_at', Types::DATETIME_MUTABLE, ['default' => 'CURRENT_TIMESTAMP']);

// Set constraints
$invoicesTable->setPrimaryKey(['id']);
$invoicesTable->addUniqueIndex(['invoice_number']);


// ==========================================
// 3. BUILD THE INVOICE ITEMS TABLE
// ==========================================
$invoiceItemsTable = $schema->createTable('invoice_items');

// Primary Auto-Increment Key
$invoiceItemsTable->addColumn('id', Types::INTEGER, ['unsigned' => true, 'autoincrement' => true]);
// Foreign Key Link back to Invoices Table
$invoiceItemsTable->addColumn('invoice_id', Types::INTEGER, ['unsigned' => true]);
// Item Details
$invoiceItemsTable->addColumn('description', Types::STRING, ['length' => 255]);
$invoiceItemsTable->addColumn('quantity', Types::INTEGER);
$invoiceItemsTable->addColumn('unit_price', Types::DECIMAL, ['precision' => 10, 'scale' => 2]);

// Set constraints
$invoiceItemsTable->setPrimaryKey(['id']);

// 💡 LINK THE TABLES TOGETHER (Foreign Key Relationship)
// This ensures if an invoice is deleted, its matching items are cleaned up automatically (CASCADE)
$invoiceItemsTable->addForeignKeyConstraint(
    'invoices',          // <-- Changed from $invoicesTable to 'invoices'
    ['invoice_id'],
    ['id'],
    ['onDelete' => 'CASCADE']
);


// ==========================================
// 4. EXECUTE AND GENERATE THE SQL RUNTIME
// ==========================================
// Assuming $conn is your valid Doctrine\DBAL\Connection instance from your app bootstrap
$platform = $conn->getDatabasePlatform();
$queries = $schema->toSql($platform);

echo "Creating database tables...\n";
foreach ($queries as $sql) {
    $conn->executeStatement($sql);
    echo "Executed: $sql\n";
}

echo "Tables created successfully!\n";