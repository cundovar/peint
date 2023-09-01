<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230830102548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_matieres DROP FOREIGN KEY FK_716989448E74CFC');
        $this->addSql('ALTER TABLE oeuvre_matieres DROP FOREIGN KEY FK_71698944F46CD258');
        $this->addSql('DROP INDEX IDX_71698944F46CD258 ON oeuvre_matieres');
        $this->addSql('DROP INDEX IDX_716989448E74CFC ON oeuvre_matieres');
        $this->addSql('ALTER TABLE oeuvre_matieres DROP oeuvre_article_id, DROP matiere_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_matieres ADD oeuvre_article_id INT DEFAULT NULL, ADD matiere_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre_matieres ADD CONSTRAINT FK_716989448E74CFC FOREIGN KEY (oeuvre_article_id) REFERENCES oeuvres (id)');
        $this->addSql('ALTER TABLE oeuvre_matieres ADD CONSTRAINT FK_71698944F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('CREATE INDEX IDX_71698944F46CD258 ON oeuvre_matieres (matiere_id)');
        $this->addSql('CREATE INDEX IDX_716989448E74CFC ON oeuvre_matieres (oeuvre_article_id)');
    }
}
