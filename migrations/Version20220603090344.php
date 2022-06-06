<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220603090344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE elt_maturite ADD projet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE elt_maturite ADD CONSTRAINT FK_F4B61103C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_F4B61103C18272 ON elt_maturite (projet_id)');
        $this->addSql('ALTER TABLE maturite ADD type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE elt_maturite DROP FOREIGN KEY FK_F4B61103C18272');
        $this->addSql('DROP INDEX IDX_F4B61103C18272 ON elt_maturite');
        $this->addSql('ALTER TABLE elt_maturite DROP projet_id');
        $this->addSql('ALTER TABLE maturite DROP type');
    }
}
