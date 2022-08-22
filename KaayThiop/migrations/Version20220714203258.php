<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714203258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ligne_bt (id INT AUTO_INCREMENT NOT NULL, lignecommande_id INT DEFAULT NULL, boissontaille_id INT DEFAULT NULL, quantite INT DEFAULT NULL, INDEX IDX_A40047D920D3031 (lignecommande_id), INDEX IDX_A40047D927A37561 (boissontaille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ligne_bt ADD CONSTRAINT FK_A40047D920D3031 FOREIGN KEY (lignecommande_id) REFERENCES ligne_commande (id)');
        $this->addSql('ALTER TABLE ligne_bt ADD CONSTRAINT FK_A40047D927A37561 FOREIGN KEY (boissontaille_id) REFERENCES taille_boisson (id)');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B36F1CA00');
        $this->addSql('DROP INDEX IDX_3170B74B36F1CA00 ON ligne_commande');
        $this->addSql('ALTER TABLE ligne_commande DROP tailleboisson_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ligne_bt');
        $this->addSql('ALTER TABLE ligne_commande ADD tailleboisson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B36F1CA00 FOREIGN KEY (tailleboisson_id) REFERENCES taille_boisson (id)');
        $this->addSql('CREATE INDEX IDX_3170B74B36F1CA00 ON ligne_commande (tailleboisson_id)');
    }
}
