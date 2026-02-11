<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260209151540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnage ADD role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486DEA000B10 FOREIGN KEY (class_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486DD60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_6AEA486DD60322AC ON personnage (role_id)');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6A5E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id)');
        $this->addSql('ALTER TABLE user_personnage ADD CONSTRAINT FK_CD8D8E81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_personnage ADD CONSTRAINT FK_CD8D8E815E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486DEA000B10');
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486DD60322AC');
        $this->addSql('DROP INDEX IDX_6AEA486DD60322AC ON personnage');
        $this->addSql('ALTER TABLE personnage DROP role_id');
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6A5E315342');
        $this->addSql('ALTER TABLE user_personnage DROP FOREIGN KEY FK_CD8D8E81A76ED395');
        $this->addSql('ALTER TABLE user_personnage DROP FOREIGN KEY FK_CD8D8E815E315342');
    }
}
