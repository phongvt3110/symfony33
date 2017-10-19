<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171019042302 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE Orders (id INT AUTO_INCREMENT NOT NULL, 
                                                    name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci,
                                                    customer_id INT NOT NULL, 
                                                    phone VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci,
                                                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
                                                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
                                                    PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE Orders');
    }
}
