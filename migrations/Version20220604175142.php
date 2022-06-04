<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604175142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE financement ADD projet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE financement ADD CONSTRAINT FK_59895F56C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_59895F56C18272 ON financement (projet_id)');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9A737ED74');
        $this->addSql('DROP INDEX IDX_50159CA9A737ED74 ON projet');
        $this->addSql('ALTER TABLE projet DROP financement_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE financement DROP FOREIGN KEY FK_59895F56C18272');
        $this->addSql('DROP INDEX IDX_59895F56C18272 ON financement');
        $this->addSql('ALTER TABLE financement DROP projet_id');
        $this->addSql('ALTER TABLE projet ADD financement_id INT NOT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9A737ED74 FOREIGN KEY (financement_id) REFERENCES financement (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_50159CA9A737ED74 ON projet (financement_id)');
    }
}
