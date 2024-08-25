<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240726000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Laravel cache tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cache (key VARCHAR(255) NOT NULL, value TEXT NOT NULL, expiration TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(key))');
        $this->addSql('CREATE TABLE cache_locks (key VARCHAR(255) NOT NULL, owner VARCHAR(255) NOT NULL, expiration TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(key))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE IF EXISTS cache');
        $this->addSql('DROP TABLE IF EXISTS cache_locks');
    }
}
