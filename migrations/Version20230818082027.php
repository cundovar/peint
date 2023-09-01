<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230818082027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oeuvre_matieres (id INT AUTO_INCREMENT NOT NULL, oeuvre_article_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, INDEX IDX_716989448E74CFC (oeuvre_article_id), INDEX IDX_71698944F46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oeuvre_matieres ADD CONSTRAINT FK_716989448E74CFC FOREIGN KEY (oeuvre_article_id) REFERENCES oeuvres (id)');
        $this->addSql('ALTER TABLE oeuvre_matieres ADD CONSTRAINT FK_71698944F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE oeuvres DROP FOREIGN KEY FK_413EEE3E82350831');
        $this->addSql('DROP INDEX IDX_413EEE3E82350831 ON oeuvres');
        $this->addSql('ALTER TABLE oeuvres DROP dimention, CHANGE matieres_id dimention_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvres ADD CONSTRAINT FK_413EEE3EE2D31623 FOREIGN KEY (dimention_id) REFERENCES matiere (id)');
        $this->addSql('CREATE INDEX IDX_413EEE3EE2D31623 ON oeuvres (dimention_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_matieres DROP FOREIGN KEY FK_716989448E74CFC');
        $this->addSql('ALTER TABLE oeuvre_matieres DROP FOREIGN KEY FK_71698944F46CD258');
        $this->addSql('DROP TABLE oeuvre_matieres');
        $this->addSql('ALTER TABLE oeuvres DROP FOREIGN KEY FK_413EEE3EE2D31623');
        $this->addSql('DROP INDEX IDX_413EEE3EE2D31623 ON oeuvres');
        $this->addSql('ALTER TABLE oeuvres ADD dimention VARCHAR(255) DEFAULT NULL, CHANGE dimention_id matieres_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvres ADD CONSTRAINT FK_413EEE3E82350831 FOREIGN KEY (matieres_id) REFERENCES matiere (id)');
        $this->addSql('CREATE INDEX IDX_413EEE3E82350831 ON oeuvres (matieres_id)');
    }
}
