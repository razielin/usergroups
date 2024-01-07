<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101174140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create users table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('user');
        $table->addColumn('user_id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $table->setPrimaryKey(array('user_id'));
        $table->addColumn('name', 'string');
        $table->addColumn('email', 'string');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('user');
    }
}
