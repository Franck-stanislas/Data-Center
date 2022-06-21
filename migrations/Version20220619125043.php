<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220619125043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet ADD caracteristique LONGTEXT DEFAULT NULL, ADD marche VARCHAR(255) DEFAULT NULL, ADD supply VARCHAR(255) DEFAULT NULL, ADD atouts LONGTEXT DEFAULT NULL, ADD valeur_ajouter LONGTEXT DEFAULT NULL, ADD eligibilite LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP caracteristique, DROP marche, DROP supply, DROP atouts, DROP valeur_ajouter, DROP eligibilite');
    }
}
