<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210402115236 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_B5852DF3A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pin AS SELECT id, user_id, title, description, created_at, updated_at FROM pin');
        $this->addSql('DROP TABLE pin');
        $this->addSql('CREATE TABLE pin (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CONSTRAINT FK_B5852DF3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO pin (id, user_id, title, description, created_at, updated_at) SELECT id, user_id, title, description, created_at, updated_at FROM __temp__pin');
        $this->addSql('DROP TABLE __temp__pin');
        $this->addSql('CREATE INDEX IDX_B5852DF3A76ED395 ON pin (user_id)');
        $this->addSql('ALTER TABLE user ADD COLUMN is_verified BOOLEAN DEFAULT FALSE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_B5852DF3A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pin AS SELECT id, user_id, title, description, created_at, updated_at FROM pin');
        $this->addSql('DROP TABLE pin');
        $this->addSql('CREATE TABLE pin (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO pin (id, user_id, title, description, created_at, updated_at) SELECT id, user_id, title, description, created_at, updated_at FROM __temp__pin');
        $this->addSql('DROP TABLE __temp__pin');
        $this->addSql('CREATE INDEX IDX_B5852DF3A76ED395 ON pin (user_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, first_name, last_name, email, roles, password, created_at, updated_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO user (id, first_name, last_name, email, roles, password, created_at, updated_at) SELECT id, first_name, last_name, email, roles, password, created_at, updated_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
