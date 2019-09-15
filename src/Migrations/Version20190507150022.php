<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190507150022 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__line AS SELECT id, string, "end" FROM line');
        $this->addSql('DROP TABLE line');
        $this->addSql('CREATE TABLE line (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, string VARCHAR(255) NOT NULL COLLATE BINARY, "end" VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO line (id, string, "end") SELECT id, string, "end" FROM __temp__line');
        $this->addSql('DROP TABLE __temp__line');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__line AS SELECT id, string, "end" FROM line');
        $this->addSql('DROP TABLE line');
        $this->addSql('CREATE TABLE line (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, string VARCHAR(255) NOT NULL, "end" INTEGER NOT NULL)');
        $this->addSql('INSERT INTO line (id, string, "end") SELECT id, string, "end" FROM __temp__line');
        $this->addSql('DROP TABLE __temp__line');
    }
}
