<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522111446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add EltMaturite table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE elt_maturite (id INT AUTO_INCREMENT NOT NULL, id_maturite_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_F4B6110352A907CB (id_maturite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE elt_maturite ADD CONSTRAINT FK_F4B6110352A907CB FOREIGN KEY (id_maturite_id) REFERENCES maturite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE elt_maturite');
    }
}
