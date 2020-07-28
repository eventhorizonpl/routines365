<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200728215223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE goal CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE deleted_at deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('ALTER TABLE note CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE deleted_at deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('ALTER TABLE profile CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE deleted_at deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('ALTER TABLE quote CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE deleted_at deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('ALTER TABLE reminder CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE deleted_at deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('ALTER TABLE routine CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE deleted_at deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE deleted_at deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE goal CHANGE created_at created_at DATETIME NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE note CHANGE created_at created_at DATETIME NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE profile CHANGE created_at created_at DATETIME NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE quote CHANGE created_at created_at DATETIME NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reminder CHANGE created_at created_at DATETIME NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE routine CHANGE created_at created_at DATETIME NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
    }
}
