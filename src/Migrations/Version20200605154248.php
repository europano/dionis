<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200605154248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, page_parent_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, auteur VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, jour_at DATETIME NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_140AB620BCF5E72D (categorie_id), INDEX IDX_140AB620499475BF (page_parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, original_document VARCHAR(255) NOT NULL, INDEX IDX_D8698A76C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620499475BF FOREIGN KEY (page_parent_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620BCF5E72D');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620499475BF');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76C4663E4');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE fichier');
    }
}
