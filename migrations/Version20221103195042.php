<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103195042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etat_commande (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_F33F0EED82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etat_commande ADD CONSTRAINT FK_F33F0EED82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande ADD etat_commande_id INT DEFAULT NULL, DROP etat_commande');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DEF9E8683 FOREIGN KEY (etat_commande_id) REFERENCES etat_commande (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DEF9E8683 ON commande (etat_commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DEF9E8683');
        $this->addSql('ALTER TABLE etat_commande DROP FOREIGN KEY FK_F33F0EED82EA2E54');
        $this->addSql('DROP TABLE etat_commande');
        $this->addSql('DROP INDEX IDX_6EEAA67DEF9E8683 ON commande');
        $this->addSql('ALTER TABLE commande ADD etat_commande VARCHAR(255) NOT NULL, DROP etat_commande_id');
    }
}
