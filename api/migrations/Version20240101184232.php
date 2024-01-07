<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101184232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create groups table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('groups');
        $table->addColumn('group_id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $table->setPrimaryKey(array('group_id'));
        $table->addColumn('group_name', 'string');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('groups');
    }
}
