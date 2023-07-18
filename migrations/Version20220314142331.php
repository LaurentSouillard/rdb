<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220314142331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE space (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE spaces');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE spaces (id INT AUTO_INCREMENT NOT NULL, reservation_id INT NOT NULL, bureau_individuel TINYINT(1) DEFAULT NULL, bureau_double TINYINT(1) DEFAULT NULL, bureau_de_groupe TINYINT(1) DEFAULT NULL, open_space TINYINT(1) DEFAULT NULL, plateau TINYINT(1) DEFAULT NULL, floor TINYINT(1) DEFAULT NULL, salle_de_reunion TINYINT(1) DEFAULT NULL, combo_reunion_bureau TINYINT(1) DEFAULT NULL, bloc TINYINT(1) DEFAULT NULL, INDEX IDX_DD2B6478B83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE spaces ADD CONSTRAINT FK_DD2B6478B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('DROP TABLE space');
    }
}
