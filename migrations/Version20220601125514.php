<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601125514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrondissement ADD departement_id INT NOT NULL');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C4CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_3A3B64C4CCF9E01E ON arrondissement (departement_id)');
        $this->addSql('ALTER TABLE commune ADD arrondissement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES arrondissement (id)');
        $this->addSql('CREATE INDEX IDX_E2E2D1EE407DBC11 ON commune (arrondissement_id)');
        $this->addSql('ALTER TABLE departement ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_C1765B6398260155 ON departement (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C4CCF9E01E');
        $this->addSql('DROP INDEX IDX_3A3B64C4CCF9E01E ON arrondissement');
        $this->addSql('ALTER TABLE arrondissement DROP departement_id');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE407DBC11');
        $this->addSql('DROP INDEX IDX_E2E2D1EE407DBC11 ON commune');
        $this->addSql('ALTER TABLE commune DROP arrondissement_id');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('DROP INDEX IDX_C1765B6398260155 ON departement');
        $this->addSql('ALTER TABLE departement DROP region_id');
    }
}
