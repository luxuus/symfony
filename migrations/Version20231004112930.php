<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231004112930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, poster VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, released_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , plot VARCHAR(255) NOT NULL, price INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO movie (id) SELECT id FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date DATE NOT NULL, categorie VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO movie (id) SELECT id FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
    }
}
