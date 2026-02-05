<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260205085300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_7B00651CA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486DEA000B10 FOREIGN KEY (class_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE user_personnage ADD CONSTRAINT FK_CD8D8E81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_personnage ADD CONSTRAINT FK_CD8D8E815E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651CA76ED395');
        $this->addSql('DROP TABLE status');
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486DEA000B10');
        $this->addSql('ALTER TABLE user_personnage DROP FOREIGN KEY FK_CD8D8E81A76ED395');
        $this->addSql('ALTER TABLE user_personnage DROP FOREIGN KEY FK_CD8D8E815E315342');
    }
}
