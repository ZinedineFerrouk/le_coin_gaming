<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407080736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, jeu_id INT NOT NULL, plateforme_id INT NOT NULL, prix DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, boite TINYINT(1) NOT NULL, INDEX IDX_F65593E58C9E392E (jeu_id), INDEX IDX_F65593E5391E226B (plateforme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeu (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_sortie DATETIME NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeu_plateforme (jeu_id INT NOT NULL, plateforme_id INT NOT NULL, INDEX IDX_14AAFE598C9E392E (jeu_id), INDEX IDX_14AAFE59391E226B (plateforme_id), PRIMARY KEY(jeu_id, plateforme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plateforme (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E58C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5391E226B FOREIGN KEY (plateforme_id) REFERENCES plateforme (id)');
        $this->addSql('ALTER TABLE jeu_plateforme ADD CONSTRAINT FK_14AAFE598C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jeu_plateforme ADD CONSTRAINT FK_14AAFE59391E226B FOREIGN KEY (plateforme_id) REFERENCES plateforme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E58C9E392E');
        $this->addSql('ALTER TABLE jeu_plateforme DROP FOREIGN KEY FK_14AAFE598C9E392E');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5391E226B');
        $this->addSql('ALTER TABLE jeu_plateforme DROP FOREIGN KEY FK_14AAFE59391E226B');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE jeu');
        $this->addSql('DROP TABLE jeu_plateforme');
        $this->addSql('DROP TABLE plateforme');
    }
}
