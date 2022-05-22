<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522152324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arrondissement (id INT AUTO_INCREMENT NOT NULL, code_dept_id INT NOT NULL, code_region_id INT NOT NULL, code_ctd INT NOT NULL, nom_ctd VARCHAR(255) NOT NULL, INDEX IDX_3A3B64C4684A6DB (code_dept_id), INDEX IDX_3A3B64C43463796D (code_region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, code_region_id INT NOT NULL, code_ctd_id INT NOT NULL, code_cec INT NOT NULL, localite VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, INDEX IDX_E2E2D1EE3463796D (code_region_id), INDEX IDX_E2E2D1EE6132BE8C (code_ctd_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, code_region_id INT NOT NULL, code_dept INT NOT NULL, nom_dept VARCHAR(255) NOT NULL, INDEX IDX_C1765B633463796D (code_region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C4684A6DB FOREIGN KEY (code_dept_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C43463796D FOREIGN KEY (code_region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE3463796D FOREIGN KEY (code_region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE6132BE8C FOREIGN KEY (code_ctd_id) REFERENCES arrondissement (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B633463796D FOREIGN KEY (code_region_id) REFERENCES region (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE6132BE8C');
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C4684A6DB');
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C43463796D');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE3463796D');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B633463796D');
        $this->addSql('DROP TABLE arrondissement');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE region');
    }
}
