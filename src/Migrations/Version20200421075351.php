<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421075351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page ADD page_id INT DEFAULT NULL, ADD enfant_id INT DEFAULT NULL, CHANGE auteur auteur VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620450D2529 FOREIGN KEY (enfant_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_140AB620C4663E4 ON page (page_id)');
        $this->addSql('CREATE INDEX IDX_140AB620450D2529 ON page (enfant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620C4663E4');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620450D2529');
        $this->addSql('DROP INDEX IDX_140AB620C4663E4 ON page');
        $this->addSql('DROP INDEX IDX_140AB620450D2529 ON page');
        $this->addSql('ALTER TABLE page DROP page_id, DROP enfant_id, CHANGE auteur auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
