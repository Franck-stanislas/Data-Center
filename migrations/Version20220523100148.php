<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523100148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C43463796D');
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C4684A6DB');
        $this->addSql('DROP INDEX IDX_3A3B64C43463796D ON arrondissement');
        $this->addSql('DROP INDEX IDX_3A3B64C4684A6DB ON arrondissement');
        $this->addSql('ALTER TABLE arrondissement ADD dept_id INT NOT NULL, ADD region_id INT NOT NULL, DROP code_dept_id, DROP code_region_id, DROP code_ctd, CHANGE nom_ctd nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C43E23E247 FOREIGN KEY (dept_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C498260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_3A3B64C43E23E247 ON arrondissement (dept_id)');
        $this->addSql('CREATE INDEX IDX_3A3B64C498260155 ON arrondissement (region_id)');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE3463796D');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE6132BE8C');
        $this->addSql('DROP INDEX IDX_E2E2D1EE6132BE8C ON commune');
        $this->addSql('DROP INDEX IDX_E2E2D1EE3463796D ON commune');
        $this->addSql('ALTER TABLE commune ADD region_id INT NOT NULL, ADD arrondissement_id INT NOT NULL, DROP code_region_id, DROP code_ctd_id, DROP code_cec');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES arrondissement (id)');
        $this->addSql('CREATE INDEX IDX_E2E2D1EE98260155 ON commune (region_id)');
        $this->addSql('CREATE INDEX IDX_E2E2D1EE407DBC11 ON commune (arrondissement_id)');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B633463796D');
        $this->addSql('DROP INDEX IDX_C1765B633463796D ON departement');
        $this->addSql('ALTER TABLE departement ADD region_id INT NOT NULL, DROP code_region_id, DROP code_dept, CHANGE nom_dept nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_C1765B6398260155 ON departement (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C43E23E247');
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C498260155');
        $this->addSql('DROP INDEX IDX_3A3B64C43E23E247 ON arrondissement');
        $this->addSql('DROP INDEX IDX_3A3B64C498260155 ON arrondissement');
        $this->addSql('ALTER TABLE arrondissement ADD code_dept_id INT NOT NULL, ADD code_region_id INT NOT NULL, ADD code_ctd INT NOT NULL, DROP dept_id, DROP region_id, CHANGE nom nom_ctd VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C43463796D FOREIGN KEY (code_region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C4684A6DB FOREIGN KEY (code_dept_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_3A3B64C43463796D ON arrondissement (code_region_id)');
        $this->addSql('CREATE INDEX IDX_3A3B64C4684A6DB ON arrondissement (code_dept_id)');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE98260155');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE407DBC11');
        $this->addSql('DROP INDEX IDX_E2E2D1EE98260155 ON commune');
        $this->addSql('DROP INDEX IDX_E2E2D1EE407DBC11 ON commune');
        $this->addSql('ALTER TABLE commune ADD code_region_id INT NOT NULL, ADD code_ctd_id INT NOT NULL, ADD code_cec INT NOT NULL, DROP region_id, DROP arrondissement_id');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE3463796D FOREIGN KEY (code_region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE6132BE8C FOREIGN KEY (code_ctd_id) REFERENCES arrondissement (id)');
        $this->addSql('CREATE INDEX IDX_E2E2D1EE6132BE8C ON commune (code_ctd_id)');
        $this->addSql('CREATE INDEX IDX_E2E2D1EE3463796D ON commune (code_region_id)');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('DROP INDEX IDX_C1765B6398260155 ON departement');
        $this->addSql('ALTER TABLE departement ADD code_dept INT NOT NULL, CHANGE region_id code_region_id INT NOT NULL, CHANGE nom nom_dept VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B633463796D FOREIGN KEY (code_region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_C1765B633463796D ON departement (code_region_id)');
    }
}
