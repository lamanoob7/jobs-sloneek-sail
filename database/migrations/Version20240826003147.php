<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240826003147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Create jobs table
        $table = $schema->createTable('jobs');
        $table->addColumn('id', 'bigint', [
            'unsigned' => true,
            'autoincrement' => true,
        ]);
        $table->addColumn('queue', 'string', ['length' => 255]);
        $table->addColumn('payload', 'text');
        $table->addColumn('attempts', 'integer', ['unsigned' => true]);
        $table->addColumn('reserved_at', 'integer', ['unsigned' => true, 'notnull' => false]);
        $table->addColumn('available_at', 'integer', ['unsigned' => true]);
        $table->addColumn('created_at', 'integer', ['unsigned' => true]);

        $table->setPrimaryKey(['id']);
        $table->addIndex(['queue']);
        $table->addIndex(['reserved_at']);
        $table->addIndex(['available_at']);
        $table->addIndex(['created_at']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('jobs');
    }
}
