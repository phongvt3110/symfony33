<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171019035221 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Customers');
        $this->addSql('ALTER TABLE Products CHANGE price price NUMERIC(10, 2) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Users CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5428AEDE7927C74 ON Users (email)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE Customers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, phone VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci, country VARCHAR(5) DEFAULT \'vi\' NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Products CHANGE price price INT DEFAULT 0 NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('DROP INDEX UNIQ_D5428AEDE7927C74 ON Users');
        $this->addSql('ALTER TABLE Users CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
    }
}
