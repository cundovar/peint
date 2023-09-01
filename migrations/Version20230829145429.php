<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829145429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_matieres ADD mat_id INT DEFAULT NULL, ADD oeuv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre_matieres ADD CONSTRAINT FK_71698944DCA7C833 FOREIGN KEY (mat_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE oeuvre_matieres ADD CONSTRAINT FK_716989445ECDF146 FOREIGN KEY (oeuv_id) REFERENCES oeuvres (id)');
        $this->addSql('CREATE INDEX IDX_71698944DCA7C833 ON oeuvre_matieres (mat_id)');
        $this->addSql('CREATE INDEX IDX_716989445ECDF146 ON oeuvre_matieres (oeuv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_matieres DROP FOREIGN KEY FK_71698944DCA7C833');
        $this->addSql('ALTER TABLE oeuvre_matieres DROP FOREIGN KEY FK_716989445ECDF146');
        $this->addSql('DROP INDEX IDX_71698944DCA7C833 ON oeuvre_matieres');
        $this->addSql('DROP INDEX IDX_716989445ECDF146 ON oeuvre_matieres');
        $this->addSql('ALTER TABLE oeuvre_matieres DROP mat_id, DROP oeuv_id');
    }
}
