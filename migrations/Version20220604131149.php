<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604131149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projet_elt_maturite (projet_id INT NOT NULL, elt_maturite_id INT NOT NULL, INDEX IDX_350C36FCC18272 (projet_id), INDEX IDX_350C36FC15DC4E34 (elt_maturite_id), PRIMARY KEY(projet_id, elt_maturite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet_elt_maturite ADD CONSTRAINT FK_350C36FCC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_elt_maturite ADD CONSTRAINT FK_350C36FC15DC4E34 FOREIGN KEY (elt_maturite_id) REFERENCES elt_maturite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE elt_maturite DROP FOREIGN KEY FK_F4B61103C18272');
        $this->addSql('DROP INDEX IDX_F4B61103C18272 ON elt_maturite');
        $this->addSql('ALTER TABLE elt_maturite DROP projet_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE projet_elt_maturite');
        $this->addSql('ALTER TABLE elt_maturite ADD projet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE elt_maturite ADD CONSTRAINT FK_F4B61103C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F4B61103C18272 ON elt_maturite (projet_id)');
    }
}
