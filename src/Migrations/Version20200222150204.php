<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200222150204 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pricelist (id INT AUTO_INCREMENT NOT NULL, caravan_id INT NOT NULL, name VARCHAR(127) DEFAULT NULL, valid_from DATETIME NOT NULL, valid_till DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, price_vat DOUBLE PRECISION NOT NULL, currency VARCHAR(127) DEFAULT NULL, INDEX IDX_5CCFEA6D6A26BF6D (caravan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pricelist ADD CONSTRAINT FK_5CCFEA6D6A26BF6D FOREIGN KEY (caravan_id) REFERENCES caravan (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pricelist');
    }
}
