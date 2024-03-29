<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203133504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Version v5';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', data LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', status VARCHAR(12) NOT NULL, type VARCHAR(24) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_C42F7784D17F50A6 (uuid), INDEX status_idx (status), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE testimonial (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id INT NOT NULL, content VARCHAR(255) DEFAULT NULL, is_visible TINYINT(1) NOT NULL, signature VARCHAR(128) DEFAULT NULL, status VARCHAR(8) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_E6BDCDF7D17F50A6 (uuid), UNIQUE INDEX UNIQ_E6BDCDF7A76ED395 (user_id), INDEX status_idx (status), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD google_authenticator_secret VARCHAR(52) DEFAULT NULL AFTER email');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649444C076E ON user (google_authenticator_secret)');
        $this->addSql('ALTER TABLE user_kyt ADD testimonial_request_sent TINYINT(1) NOT NULL AFTER routines_sent');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE testimonial');
        $this->addSql('DROP INDEX UNIQ_8D93D649444C076E ON user');
        $this->addSql('ALTER TABLE user DROP google_authenticator_secret');
        $this->addSql('ALTER TABLE user_kyt DROP testimonial_request_sent');
    }
}
