<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921000055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvres_categorie DROP FOREIGN KEY FK_F214A0594928CE22');
        $this->addSql('ALTER TABLE oeuvres_categorie DROP FOREIGN KEY FK_F214A059BCF5E72D');
        $this->addSql('DROP TABLE oeuvres_categorie');
        $this->addSql('ALTER TABLE categorie DROP nom');
        $this->addSql('ALTER TABLE oeuvres ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvres ADD CONSTRAINT FK_413EEE3EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_413EEE3EBCF5E72D ON oeuvres (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oeuvres_categorie (oeuvres_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_F214A059BCF5E72D (categorie_id), INDEX IDX_F214A0594928CE22 (oeuvres_id), PRIMARY KEY(oeuvres_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE oeuvres_categorie ADD CONSTRAINT FK_F214A0594928CE22 FOREIGN KEY (oeuvres_id) REFERENCES oeuvres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvres_categorie ADD CONSTRAINT FK_F214A059BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie ADD nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvres DROP FOREIGN KEY FK_413EEE3EBCF5E72D');
        $this->addSql('DROP INDEX IDX_413EEE3EBCF5E72D ON oeuvres');
        $this->addSql('ALTER TABLE oeuvres DROP categorie_id');
    }
}
