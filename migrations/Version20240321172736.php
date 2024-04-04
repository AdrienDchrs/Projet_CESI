<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240321172736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE publication (
                       id INT AUTO_INCREMENT NOT NULL, 
                       id_u_id INT NOT NULL, 
                       titre LONGTEXT NOT NULL, 
                       texte LONGTEXT NOT NULL, 
                       image_link LONGTEXT NOT NULL, 
                       INDEX IDX_AF3C67796F858F92 (id_u_id), 
                       PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');


        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67796F858F92 FOREIGN KEY (id_u_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67796F858F92');
        $this->addSql('DROP TABLE publication');
    }
}
