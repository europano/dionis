<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Categorie;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200611191050 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Ajout des 3 catégories principales';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO categorie (titre) VALUES ('".Categorie::A_LA_UNE."')");
        $this->addSql("INSERT INTO categorie (titre) VALUES ('".Categorie::VIE_DES_PROJETS."')");
        $this->addSql("INSERT INTO categorie (titre) VALUES ('".Categorie::AGENDA."')");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
