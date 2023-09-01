<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920230400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oeuvres_categorie (oeuvres_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_F214A0594928CE22 (oeuvres_id), INDEX IDX_F214A059BCF5E72D (categorie_id), PRIMARY KEY(oeuvres_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oeuvres_categorie ADD CONSTRAINT FK_F214A0594928CE22 FOREIGN KEY (oeuvres_id) REFERENCES oeuvres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvres_categorie ADD CONSTRAINT FK_F214A059BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvres_categorie DROP FOREIGN KEY FK_F214A0594928CE22');
        $this->addSql('ALTER TABLE oeuvres_categorie DROP FOREIGN KEY FK_F214A059BCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE oeuvres_categorie');
    }
}
