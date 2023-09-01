<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230816153541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvres_matiere DROP FOREIGN KEY FK_7C673D16F46CD258');
        $this->addSql('ALTER TABLE oeuvres_matiere DROP FOREIGN KEY FK_7C673D164928CE22');
        $this->addSql('DROP TABLE oeuvres_matiere');
        $this->addSql('ALTER TABLE oeuvres ADD matieres_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvres ADD CONSTRAINT FK_413EEE3E82350831 FOREIGN KEY (matieres_id) REFERENCES matiere (id)');
        $this->addSql('CREATE INDEX IDX_413EEE3E82350831 ON oeuvres (matieres_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oeuvres_matiere (oeuvres_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_7C673D16F46CD258 (matiere_id), INDEX IDX_7C673D164928CE22 (oeuvres_id), PRIMARY KEY(oeuvres_id, matiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE oeuvres_matiere ADD CONSTRAINT FK_7C673D16F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvres_matiere ADD CONSTRAINT FK_7C673D164928CE22 FOREIGN KEY (oeuvres_id) REFERENCES oeuvres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvres DROP FOREIGN KEY FK_413EEE3E82350831');
        $this->addSql('DROP INDEX IDX_413EEE3E82350831 ON oeuvres');
        $this->addSql('ALTER TABLE oeuvres DROP matieres_id');
    }
}
