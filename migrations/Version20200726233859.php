<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200726233859 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE session (sid VARBINARY(128) NOT NULL PRIMARY KEY, sdata BLOB NOT NULL, slifetime INTEGER UNSIGNED NOT NULL, stime INTEGER UNSIGNED NOT NULL) COLLATE utf8mb4_bin, ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goal (id INT AUTO_INCREMENT NOT NULL, routine_id INT NOT NULL, user_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, is_completed TINYINT(1) NOT NULL, name VARCHAR(64) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FCDCEB2EF27A94C7 (routine_id), INDEX IDX_FCDCEB2EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, routine_id INT NOT NULL, user_id INT NOT NULL, content VARCHAR(2048) NOT NULL, title VARCHAR(255) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CFBDFA14F27A94C7 (routine_id), INDEX IDX_CFBDFA14A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, country VARCHAR(2) DEFAULT NULL, phone VARCHAR(35) DEFAULT NULL COMMENT \'(DC2Type:phone_number)\', theme VARCHAR(8) DEFAULT NULL, timezone VARCHAR(36) DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8157AA0F444F97DD (phone), UNIQUE INDEX UNIQ_8157AA0FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quote (id INT AUTO_INCREMENT NOT NULL, author VARCHAR(64) NOT NULL, content VARCHAR(255) NOT NULL, content_md5 VARCHAR(32) NOT NULL, string_length INT NOT NULL, type VARCHAR(16) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', is_visible TINYINT(1) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_6B71CBF45D87BD14 (content_md5), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reminder (id INT AUTO_INCREMENT NOT NULL, routine_id INT NOT NULL, user_id INT NOT NULL, hour TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', minutes_before INT NOT NULL, next_date DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', previous_date DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', send_email TINYINT(1) NOT NULL, send_sms TINYINT(1) NOT NULL, type VARCHAR(10) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', is_enabled TINYINT(1) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_40374F40F27A94C7 (routine_id), INDEX IDX_40374F40A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE routine (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, name VARCHAR(64) NOT NULL, type VARCHAR(16) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', is_enabled TINYINT(1) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4BF6D8D6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', is_verified TINYINT(1) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', is_enabled TINYINT(1) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EF27A94C7 FOREIGN KEY (routine_id) REFERENCES routine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F27A94C7 FOREIGN KEY (routine_id) REFERENCES routine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reminder ADD CONSTRAINT FK_40374F40F27A94C7 FOREIGN KEY (routine_id) REFERENCES routine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reminder ADD CONSTRAINT FK_40374F40A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE routine ADD CONSTRAINT FK_4BF6D8D6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EF27A94C7');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F27A94C7');
        $this->addSql('ALTER TABLE reminder DROP FOREIGN KEY FK_40374F40F27A94C7');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EA76ED395');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A76ED395');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('ALTER TABLE reminder DROP FOREIGN KEY FK_40374F40A76ED395');
        $this->addSql('ALTER TABLE routine DROP FOREIGN KEY FK_4BF6D8D6A76ED395');
        $this->addSql('DROP TABLE goal');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE reminder');
        $this->addSql('DROP TABLE routine');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE session');
    }
}
