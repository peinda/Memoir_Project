<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221106194041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit_detail_commande DROP FOREIGN KEY FK_B83A8FB4EDE14305');
        $this->addSql('ALTER TABLE produit_detail_commande DROP FOREIGN KEY FK_B83A8FB4F347EFB');
        $this->addSql('DROP TABLE produit_detail_commande');
        $this->addSql('ALTER TABLE commande CHANGE adresse_livraison adresse_livraison VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE detail_commande ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE detail_commande ADD CONSTRAINT FK_98344FA6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_98344FA6F347EFB ON detail_commande (produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_detail_commande (produit_id INT NOT NULL, detail_commande_id INT NOT NULL, INDEX IDX_B83A8FB4F347EFB (produit_id), INDEX IDX_B83A8FB4EDE14305 (detail_commande_id), PRIMARY KEY(produit_id, detail_commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE produit_detail_commande ADD CONSTRAINT FK_B83A8FB4EDE14305 FOREIGN KEY (detail_commande_id) REFERENCES detail_commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_detail_commande ADD CONSTRAINT FK_B83A8FB4F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande CHANGE adresse_livraison adresse_livraison VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE detail_commande DROP FOREIGN KEY FK_98344FA6F347EFB');
        $this->addSql('DROP INDEX IDX_98344FA6F347EFB ON detail_commande');
        $this->addSql('ALTER TABLE detail_commande DROP produit_id');
    }
}
