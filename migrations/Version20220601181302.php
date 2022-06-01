<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601181302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE arrondissement (id INT AUTO_INCREMENT NOT NULL, dept_id INT NOT NULL, region_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_3A3B64C43E23E247 (dept_id), INDEX IDX_3A3B64C498260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, arrondissement_id INT NOT NULL, localite VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, INDEX IDX_E2E2D1EE98260155 (region_id), INDEX IDX_E2E2D1EE407DBC11 (arrondissement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_C1765B6398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE elt_maturite (id INT AUTO_INCREMENT NOT NULL, id_maturite_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_F4B6110352A907CB (id_maturite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE financement (id INT AUTO_INCREMENT NOT NULL, nom_financement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maturite (id INT AUTO_INCREMENT NOT NULL, nom_maturite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C43E23E247 FOREIGN KEY (dept_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C498260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES arrondissement (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE elt_maturite ADD CONSTRAINT FK_F4B6110352A907CB FOREIGN KEY (id_maturite_id) REFERENCES maturite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE407DBC11');
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C43E23E247');
        $this->addSql('ALTER TABLE elt_maturite DROP FOREIGN KEY FK_F4B6110352A907CB');
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C498260155');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE98260155');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE arrondissement');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE elt_maturite');
        $this->addSql('DROP TABLE financement');
        $this->addSql('DROP TABLE maturite');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
