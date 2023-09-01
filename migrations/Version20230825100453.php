<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230825100453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_matieres ADD oeuvres_id INT DEFAULT NULL, ADD matieres_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre_matieres ADD CONSTRAINT FK_716989444928CE22 FOREIGN KEY (oeuvres_id) REFERENCES oeuvres (id)');
        $this->addSql('ALTER TABLE oeuvre_matieres ADD CONSTRAINT FK_7169894482350831 FOREIGN KEY (matieres_id) REFERENCES matiere (id)');
        $this->addSql('CREATE INDEX IDX_716989444928CE22 ON oeuvre_matieres (oeuvres_id)');
        $this->addSql('CREATE INDEX IDX_7169894482350831 ON oeuvre_matieres (matieres_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_matieres DROP FOREIGN KEY FK_716989444928CE22');
        $this->addSql('ALTER TABLE oeuvre_matieres DROP FOREIGN KEY FK_7169894482350831');
        $this->addSql('DROP INDEX IDX_716989444928CE22 ON oeuvre_matieres');
        $this->addSql('DROP INDEX IDX_7169894482350831 ON oeuvre_matieres');
        $this->addSql('ALTER TABLE oeuvre_matieres DROP oeuvres_id, DROP matieres_id');
    }
}
