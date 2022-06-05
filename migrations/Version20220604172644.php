<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604172644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE projet_commune');
        $this->addSql('ALTER TABLE projet ADD commune_id INT NOT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('CREATE INDEX IDX_50159CA9131A4F72 ON projet (commune_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projet_commune (projet_id INT NOT NULL, commune_id INT NOT NULL, INDEX IDX_60C88C9F131A4F72 (commune_id), INDEX IDX_60C88C9FC18272 (projet_id), PRIMARY KEY(projet_id, commune_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE projet_commune ADD CONSTRAINT FK_60C88C9F131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_commune ADD CONSTRAINT FK_60C88C9FC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9131A4F72');
        $this->addSql('DROP INDEX IDX_50159CA9131A4F72 ON projet');
        $this->addSql('ALTER TABLE projet DROP commune_id');
    }
}
