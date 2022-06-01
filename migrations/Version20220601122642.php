<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601122642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C43E23E247');
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C498260155');
        $this->addSql('DROP INDEX IDX_3A3B64C498260155 ON arrondissement');
        $this->addSql('DROP INDEX IDX_3A3B64C43E23E247 ON arrondissement');
        $this->addSql('ALTER TABLE arrondissement DROP dept_id, DROP region_id');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE407DBC11');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE98260155');
        $this->addSql('DROP INDEX IDX_E2E2D1EE407DBC11 ON commune');
        $this->addSql('DROP INDEX IDX_E2E2D1EE98260155 ON commune');
        $this->addSql('ALTER TABLE commune DROP region_id, DROP arrondissement_id');
        $this->addSql('ALTER TABLE departement DROP region_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrondissement ADD dept_id INT NOT NULL, ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C43E23E247 FOREIGN KEY (dept_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C498260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_3A3B64C498260155 ON arrondissement (region_id)');
        $this->addSql('CREATE INDEX IDX_3A3B64C43E23E247 ON arrondissement (dept_id)');
        $this->addSql('ALTER TABLE commune ADD region_id INT NOT NULL, ADD arrondissement_id INT NOT NULL');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES arrondissement (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_E2E2D1EE407DBC11 ON commune (arrondissement_id)');
        $this->addSql('CREATE INDEX IDX_E2E2D1EE98260155 ON commune (region_id)');
        $this->addSql('ALTER TABLE departement ADD region_id INT NOT NULL');
    }
}
