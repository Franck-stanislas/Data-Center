<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604164909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE maturite_financement (maturite_id INT NOT NULL, financement_id INT NOT NULL, INDEX IDX_8840ACCA4ABBCA3C (maturite_id), INDEX IDX_8840ACCAA737ED74 (financement_id), PRIMARY KEY(maturite_id, financement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE maturite_financement ADD CONSTRAINT FK_8840ACCA4ABBCA3C FOREIGN KEY (maturite_id) REFERENCES maturite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maturite_financement ADD CONSTRAINT FK_8840ACCAA737ED74 FOREIGN KEY (financement_id) REFERENCES financement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE financement DROP FOREIGN KEY FK_59895F564ABBCA3C');
        $this->addSql('DROP INDEX IDX_59895F564ABBCA3C ON financement');
        $this->addSql('ALTER TABLE financement DROP maturite_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE maturite_financement');
        $this->addSql('ALTER TABLE financement ADD maturite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE financement ADD CONSTRAINT FK_59895F564ABBCA3C FOREIGN KEY (maturite_id) REFERENCES maturite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_59895F564ABBCA3C ON financement (maturite_id)');
    }
}
