<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221016135803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_detail_commande (produit_id INT NOT NULL, detail_commande_id INT NOT NULL, INDEX IDX_B83A8FB4F347EFB (produit_id), INDEX IDX_B83A8FB4EDE14305 (detail_commande_id), PRIMARY KEY(produit_id, detail_commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_commande (user_id INT NOT NULL, commande_id INT NOT NULL, INDEX IDX_8E67427DA76ED395 (user_id), INDEX IDX_8E67427D82EA2E54 (commande_id), PRIMARY KEY(user_id, commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit_detail_commande ADD CONSTRAINT FK_B83A8FB4F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_detail_commande ADD CONSTRAINT FK_B83A8FB4EDE14305 FOREIGN KEY (detail_commande_id) REFERENCES detail_commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_commande ADD CONSTRAINT FK_8E67427DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_commande ADD CONSTRAINT FK_8E67427D82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_commande ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE detail_commande ADD CONSTRAINT FK_98344FA682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98344FA682EA2E54 ON detail_commande (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit_detail_commande DROP FOREIGN KEY FK_B83A8FB4F347EFB');
        $this->addSql('ALTER TABLE produit_detail_commande DROP FOREIGN KEY FK_B83A8FB4EDE14305');
        $this->addSql('ALTER TABLE user_commande DROP FOREIGN KEY FK_8E67427DA76ED395');
        $this->addSql('ALTER TABLE user_commande DROP FOREIGN KEY FK_8E67427D82EA2E54');
        $this->addSql('DROP TABLE produit_detail_commande');
        $this->addSql('DROP TABLE user_commande');
        $this->addSql('ALTER TABLE detail_commande DROP FOREIGN KEY FK_98344FA682EA2E54');
        $this->addSql('DROP INDEX UNIQ_98344FA682EA2E54 ON detail_commande');
        $this->addSql('ALTER TABLE detail_commande DROP commande_id');
    }
}
