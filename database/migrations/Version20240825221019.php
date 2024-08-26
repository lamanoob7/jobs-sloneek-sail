<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240825221019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles (uuid UUID NOT NULL, article_category_id UUID DEFAULT NULL, blogger_uuid UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, abstract VARCHAR(500) NOT NULL, text TEXT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, removed TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_BFDD316888C5F785 ON articles (article_category_id)');
        $this->addSql('CREATE INDEX IDX_BFDD3168F2AE321D ON articles (blogger_uuid)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316888C5F785 FOREIGN KEY (article_category_id) REFERENCES article_categories (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168F2AE321D FOREIGN KEY (blogger_uuid) REFERENCES bloggers (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP CONSTRAINT FK_BFDD316888C5F785');
        $this->addSql('ALTER TABLE articles DROP CONSTRAINT FK_BFDD3168F2AE321D');
        $this->addSql('DROP TABLE articles');
    }
}
