<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007064426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oeuvres_matiere (oeuvres_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_7C673D164928CE22 (oeuvres_id), INDEX IDX_7C673D16F46CD258 (matiere_id), PRIMARY KEY(oeuvres_id, matiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oeuvres_matiere ADD CONSTRAINT FK_7C673D164928CE22 FOREIGN KEY (oeuvres_id) REFERENCES oeuvres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvres_matiere ADD CONSTRAINT FK_7C673D16F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_oeuvres DROP FOREIGN KEY FK_221861C24928CE22');
        $this->addSql('ALTER TABLE matiere_oeuvres DROP FOREIGN KEY FK_221861C2F46CD258');
        $this->addSql('DROP TABLE matiere_oeuvres');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matiere_oeuvres (matiere_id INT NOT NULL, oeuvres_id INT NOT NULL, INDEX IDX_221861C2F46CD258 (matiere_id), INDEX IDX_221861C24928CE22 (oeuvres_id), PRIMARY KEY(matiere_id, oeuvres_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE matiere_oeuvres ADD CONSTRAINT FK_221861C24928CE22 FOREIGN KEY (oeuvres_id) REFERENCES oeuvres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_oeuvres ADD CONSTRAINT FK_221861C2F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvres_matiere DROP FOREIGN KEY FK_7C673D164928CE22');
        $this->addSql('ALTER TABLE oeuvres_matiere DROP FOREIGN KEY FK_7C673D16F46CD258');
        $this->addSql('DROP TABLE oeuvres_matiere');
    }
}
