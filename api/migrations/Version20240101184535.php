<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101184535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('user_groups');
        $table->addColumn('group_id', 'integer', ['unsigned' => true]);
        $table->addColumn('user_id', 'integer', ['unsigned' => true]);
        $table->setPrimaryKey(['user_id', 'group_id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('user_groups');
    }
}
