<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230831103043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_matieres DROP FOREIGN KEY FK_716989445ECDF146');
        $this->addSql('ALTER TABLE oeuvre_matieres DROP FOREIGN KEY FK_71698944DCA7C833');
        $this->addSql('DROP TABLE oeuvre_matieres');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oeuvre_matieres (id INT AUTO_INCREMENT NOT NULL, mat_id INT NOT NULL, oeuv_id INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_716989445ECDF146 (oeuv_id), INDEX IDX_71698944DCA7C833 (mat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE oeuvre_matieres ADD CONSTRAINT FK_716989445ECDF146 FOREIGN KEY (oeuv_id) REFERENCES oeuvres (id)');
        $this->addSql('ALTER TABLE oeuvre_matieres ADD CONSTRAINT FK_71698944DCA7C833 FOREIGN KEY (mat_id) REFERENCES matiere (id)');
    }
}
