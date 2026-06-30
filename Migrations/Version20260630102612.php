<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Types\Types;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260630102612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
       $users = $schema->createTable("users");
       // $users->addColumn("id", "integer")->setAutoincrement(true);
       $users->addColumn("id", Types::INTEGER, ["autoincrement" => true]);
       $users->setPrimaryKey(["id"]);
       $users->addColumn("username", Types::STRING, ["length" => 255,"notnull" => true]);
       $users->addColumn('created_at', Types::DATETIME_MUTABLE,['default' => 'CURRENT_TIMESTAMP']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable("users");
    }
}
