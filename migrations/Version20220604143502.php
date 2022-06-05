<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604143502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE financement ADD maturite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE financement ADD CONSTRAINT FK_59895F564ABBCA3C FOREIGN KEY (maturite_id) REFERENCES maturite (id)');
        $this->addSql('CREATE INDEX IDX_59895F564ABBCA3C ON financement (maturite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE financement DROP FOREIGN KEY FK_59895F564ABBCA3C');
        $this->addSql('DROP INDEX IDX_59895F564ABBCA3C ON financement');
        $this->addSql('ALTER TABLE financement DROP maturite_id');
    }
}
