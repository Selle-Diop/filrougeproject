<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714145354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taille_boisson (id INT AUTO_INCREMENT NOT NULL, boisson_id INT DEFAULT NULL, taille_id INT DEFAULT NULL, stock_boisson INT DEFAULT NULL, INDEX IDX_59FAC268734B8089 (boisson_id), INDEX IDX_59FAC268FF25611A (taille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE taille_boisson ADD CONSTRAINT FK_59FAC268734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
        $this->addSql('ALTER TABLE taille_boisson ADD CONSTRAINT FK_59FAC268FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('DROP TABLE boisson_taille');
        $this->addSql('ALTER TABLE boisson DROP stockboisson');
        $this->addSql('ALTER TABLE ligne_commande ADD tailleboisson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B36F1CA00 FOREIGN KEY (tailleboisson_id) REFERENCES taille_boisson (id)');
        $this->addSql('CREATE INDEX IDX_3170B74B36F1CA00 ON ligne_commande (tailleboisson_id)');
        $this->addSql('ALTER TABLE taille DROP prix');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B36F1CA00');
        $this->addSql('CREATE TABLE boisson_taille (boisson_id INT NOT NULL, taille_id INT NOT NULL, INDEX IDX_E7A2EE1734B8089 (boisson_id), INDEX IDX_E7A2EE1FF25611A (taille_id), PRIMARY KEY(boisson_id, taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE boisson_taille ADD CONSTRAINT FK_E7A2EE1FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boisson_taille ADD CONSTRAINT FK_E7A2EE1734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE taille_boisson');
        $this->addSql('ALTER TABLE boisson ADD stockboisson INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_3170B74B36F1CA00 ON ligne_commande');
        $this->addSql('ALTER TABLE ligne_commande DROP tailleboisson_id');
        $this->addSql('ALTER TABLE taille ADD prix DOUBLE PRECISION DEFAULT NULL');
    }
}
