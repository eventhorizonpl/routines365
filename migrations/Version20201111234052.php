<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201111234052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id INT NOT NULL, comment VARCHAR(2048) DEFAULT NULL, content VARCHAR(2048) NOT NULL, status VARCHAR(8) NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(16) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_4C62E638D17F50A6 (uuid), INDEX IDX_4C62E638A76ED395 (user_id), INDEX type_idx (type), INDEX status_idx (status), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, is_completed TINYINT(1) NOT NULL, name VARCHAR(64) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_2FB3D0EED17F50A6 (uuid), INDEX IDX_2FB3D0EEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE saved_email (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id INT NOT NULL, email VARCHAR(180) NOT NULL, type VARCHAR(16) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_8A41A76DD17F50A6 (uuid), INDEX IDX_8A41A76DA76ED395 (user_id), INDEX email_idx (email), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE saved_email ADD CONSTRAINT FK_8A41A76DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE goal ADD project_id INT DEFAULT NULL AFTER uuid');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_FCDCEB2E166D1F9C ON goal (project_id)');
        $this->addSql('ALTER TABLE kpi ADD completed_routine_counter INT NOT NULL AFTER account_operation_counter, ADD contact_counter INT NOT NULL AFTER completed_routine_counter, ADD project_counter INT NOT NULL AFTER profile_counter, ADD reward_counter INT NOT NULL AFTER reminder_message_counter, ADD saved_email_counter INT NOT NULL AFTER routine_counter');
        $this->addSql('ALTER TABLE reminder ADD next_date_local_time DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\' AFTER next_date');
        $this->addSql('ALTER TABLE user ADD last_login_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\' AFTER deleted_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E166D1F9C');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE saved_email');
        $this->addSql('DROP INDEX IDX_FCDCEB2E166D1F9C ON goal');
        $this->addSql('ALTER TABLE goal DROP project_id');
        $this->addSql('ALTER TABLE kpi DROP completed_routine_counter, DROP contact_counter, DROP project_counter, DROP reward_counter, DROP saved_email_counter');
        $this->addSql('ALTER TABLE reminder DROP next_date_local_time');
        $this->addSql('ALTER TABLE user DROP last_login_at');
    }
}
