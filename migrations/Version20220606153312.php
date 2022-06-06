<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220606153312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet ADD arrondissement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES arrondissement (id)');
        $this->addSql('CREATE INDEX IDX_50159CA9407DBC11 ON projet (arrondissement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9407DBC11');
        $this->addSql('DROP INDEX IDX_50159CA9407DBC11 ON projet');
        $this->addSql('ALTER TABLE projet DROP arrondissement_id');
    }
}
