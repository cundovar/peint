<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230818092322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvres DROP FOREIGN KEY FK_413EEE3EE2D31623');
        $this->addSql('DROP INDEX IDX_413EEE3EE2D31623 ON oeuvres');
        $this->addSql('ALTER TABLE oeuvres ADD matieres_id INT DEFAULT NULL, CHANGE dimention dimention VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvres ADD CONSTRAINT FK_413EEE3E82350831 FOREIGN KEY (matieres_id) REFERENCES matiere (id)');
        $this->addSql('CREATE INDEX IDX_413EEE3E82350831 ON oeuvres (matieres_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvres DROP FOREIGN KEY FK_413EEE3E82350831');
        $this->addSql('DROP INDEX IDX_413EEE3E82350831 ON oeuvres');
        $this->addSql('ALTER TABLE oeuvres DROP matieres_id, CHANGE dimention dimention INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvres ADD CONSTRAINT FK_413EEE3EE2D31623 FOREIGN KEY (dimention) REFERENCES matiere (id)');
        $this->addSql('CREATE INDEX IDX_413EEE3EE2D31623 ON oeuvres (dimention)');
    }
}
