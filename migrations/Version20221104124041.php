<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221104124041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_commande DROP FOREIGN KEY FK_8E67427D82EA2E54');
        $this->addSql('ALTER TABLE user_commande DROP FOREIGN KEY FK_8E67427DA76ED395');
        $this->addSql('DROP TABLE user_commande');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DEF9E8683');
        $this->addSql('DROP INDEX IDX_6EEAA67DEF9E8683 ON commande');
        $this->addSql('ALTER TABLE commande ADD etat_id INT DEFAULT NULL, CHANGE etat_commande_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DD5E86FF FOREIGN KEY (etat_id) REFERENCES etat_commande (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DA76ED395 ON commande (user_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DD5E86FF ON commande (etat_id)');
        $this->addSql('ALTER TABLE detail_commande DROP INDEX UNIQ_98344FA682EA2E54, ADD INDEX IDX_98344FA682EA2E54 (commande_id)');
        $this->addSql('ALTER TABLE etat_commande DROP FOREIGN KEY FK_F33F0EED82EA2E54');
        $this->addSql('DROP INDEX IDX_F33F0EED82EA2E54 ON etat_commande');
        $this->addSql('ALTER TABLE etat_commande DROP commande_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_commande (user_id INT NOT NULL, commande_id INT NOT NULL, INDEX IDX_8E67427DA76ED395 (user_id), INDEX IDX_8E67427D82EA2E54 (commande_id), PRIMARY KEY(user_id, commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_commande ADD CONSTRAINT FK_8E67427D82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_commande ADD CONSTRAINT FK_8E67427DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DD5E86FF');
        $this->addSql('DROP INDEX IDX_6EEAA67DA76ED395 ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67DD5E86FF ON commande');
        $this->addSql('ALTER TABLE commande ADD etat_commande_id INT DEFAULT NULL, DROP user_id, DROP etat_id');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DEF9E8683 FOREIGN KEY (etat_commande_id) REFERENCES etat_commande (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DEF9E8683 ON commande (etat_commande_id)');
        $this->addSql('ALTER TABLE detail_commande DROP INDEX IDX_98344FA682EA2E54, ADD UNIQUE INDEX UNIQ_98344FA682EA2E54 (commande_id)');
        $this->addSql('ALTER TABLE etat_commande ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etat_commande ADD CONSTRAINT FK_F33F0EED82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_F33F0EED82EA2E54 ON etat_commande (commande_id)');
    }
}
