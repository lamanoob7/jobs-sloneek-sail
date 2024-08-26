<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240825000056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bloggers_article_categories (article_categories_id UUID NOT NULL, blogger_id UUID NOT NULL, PRIMARY KEY(article_categories_id, blogger_id))');
        $this->addSql('CREATE INDEX IDX_4598C33C25C9FB12 ON bloggers_article_categories (article_categories_id)');
        $this->addSql('CREATE INDEX IDX_4598C33CD700BD1D ON bloggers_article_categories (blogger_id)');
        $this->addSql('ALTER TABLE bloggers_article_categories ADD CONSTRAINT FK_4598C33C25C9FB12 FOREIGN KEY (article_categories_id) REFERENCES article_categories (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bloggers_article_categories ADD CONSTRAINT FK_4598C33CD700BD1D FOREIGN KEY (blogger_id) REFERENCES bloggers (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bloggers_article_categories DROP CONSTRAINT FK_4598C33C25C9FB12');
        $this->addSql('ALTER TABLE bloggers_article_categories DROP CONSTRAINT FK_4598C33CD700BD1D');
        $this->addSql('DROP TABLE bloggers_article_categories');
    }
}
