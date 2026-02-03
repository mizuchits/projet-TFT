<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260203120531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE personnage (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, dmg_stat INT NOT NULL, hp_stat INT NOT NULL, class_id INT DEFAULT NULL, INDEX IDX_6AEA486DEA000B10 (class_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user_personnage (user_id INT NOT NULL, personnage_id INT NOT NULL, INDEX IDX_CD8D8E81A76ED395 (user_id), INDEX IDX_CD8D8E815E315342 (personnage_id), PRIMARY KEY (user_id, personnage_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486DEA000B10 FOREIGN KEY (class_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE user_personnage ADD CONSTRAINT FK_CD8D8E81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_personnage ADD CONSTRAINT FK_CD8D8E815E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486DEA000B10');
        $this->addSql('ALTER TABLE user_personnage DROP FOREIGN KEY FK_CD8D8E81A76ED395');
        $this->addSql('ALTER TABLE user_personnage DROP FOREIGN KEY FK_CD8D8E815E315342');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE personnage');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_personnage');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
