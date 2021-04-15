<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210120145715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Version v4';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', question_id INT NOT NULL, content VARCHAR(255) NOT NULL, is_enabled TINYINT(1) NOT NULL, position INT NOT NULL, type VARCHAR(24) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_DADD4A25D17F50A6 (uuid), INDEX IDX_DADD4A251E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', questionnaire_id INT NOT NULL, is_enabled TINYINT(1) NOT NULL, position INT NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(24) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_B6F7494ED17F50A6 (uuid), INDEX IDX_B6F7494ECE07E8FF (questionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', description VARCHAR(255) DEFAULT NULL, is_enabled TINYINT(1) NOT NULL, title VARCHAR(255) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_7A64DAFD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retention (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', data LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', date DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_2D7F0E8CD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_kyt (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id INT NOT NULL, basic_configuration_learned TINYINT(1) NOT NULL, basic_configuration_sent TINYINT(1) NOT NULL, completing_routines_learned TINYINT(1) NOT NULL, completing_routines_sent TINYINT(1) NOT NULL, date_of_last_message DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', goals_learned TINYINT(1) NOT NULL, goals_sent TINYINT(1) NOT NULL, notes_learned TINYINT(1) NOT NULL, notes_sent TINYINT(1) NOT NULL, projects_learned TINYINT(1) NOT NULL, projects_sent TINYINT(1) NOT NULL, reminders_learned TINYINT(1) NOT NULL, reminders_sent TINYINT(1) NOT NULL, rewards_learned TINYINT(1) NOT NULL, rewards_sent TINYINT(1) NOT NULL, routines_learned TINYINT(1) NOT NULL, routines_sent TINYINT(1) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_F940EBC2D17F50A6 (uuid), UNIQUE INDEX UNIQ_F940EBC2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_questionnaire (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', questionnaire_id INT NOT NULL, user_id INT NOT NULL, completed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', is_completed TINYINT(1) NOT NULL, is_rewarded TINYINT(1) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_E928E0FFD17F50A6 (uuid), INDEX IDX_E928E0FFCE07E8FF (questionnaire_id), INDEX IDX_E928E0FFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_questionnaire_answer (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', answer_id INT NOT NULL, user_questionnaire_id INT NOT NULL, content VARCHAR(255) DEFAULT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_FD5A9663D17F50A6 (uuid), INDEX IDX_FD5A9663AA334807 (answer_id), INDEX IDX_FD5A9663B312AA22 (user_questionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ECE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_kyt ADD CONSTRAINT FK_F940EBC2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_questionnaire ADD CONSTRAINT FK_E928E0FFCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_questionnaire ADD CONSTRAINT FK_E928E0FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_questionnaire_answer ADD CONSTRAINT FK_FD5A9663AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_questionnaire_answer ADD CONSTRAINT FK_FD5A9663B312AA22 FOREIGN KEY (user_questionnaire_id) REFERENCES user_questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account ADD available_browser_notifications INT NOT NULL AFTER user_id');
        $this->addSql('ALTER TABLE account_operation ADD browser_notifications INT NOT NULL AFTER reminder_message_id');
        $this->addSql('ALTER TABLE kpi ADD answer_counter INT NOT NULL AFTER achievement_counter, ADD question_counter INT NOT NULL AFTER promotion_counter, ADD questionnaire_counter INT NOT NULL AFTER question_counter, ADD retention_counter INT NOT NULL AFTER reminder_message_counter, ADD user_kyt_counter INT NOT NULL AFTER user_kpi_counter, ADD user_questionnaire_counter INT NOT NULL AFTER user_kyt_counter, ADD user_questionnaire_answer_counter INT NOT NULL AFTER user_questionnaire_counter');
        $this->addSql('ALTER TABLE promotion ADD browser_notifications INT NOT NULL AFTER uuid');
        $this->addSql('ALTER TABLE reminder ADD send_to_browser TINYINT(1) NOT NULL AFTER send_sms');
        $this->addSql('ALTER TABLE reminder_message ADD is_read_from_browser TINYINT(1) NOT NULL AFTER content');
        $this->addSql('ALTER TABLE user ADD api_token CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\' AFTER referrer_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497BA2F5EB ON user (api_token)');
        $this->addSql('ALTER TABLE user_kpi ADD efficiency11 INT NOT NULL AFTER date, ADD user_questionnaire_counter INT NOT NULL AFTER type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_questionnaire_answer DROP FOREIGN KEY FK_FD5A9663AA334807');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ECE07E8FF');
        $this->addSql('ALTER TABLE user_questionnaire DROP FOREIGN KEY FK_E928E0FFCE07E8FF');
        $this->addSql('ALTER TABLE user_questionnaire_answer DROP FOREIGN KEY FK_FD5A9663B312AA22');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE retention');
        $this->addSql('DROP TABLE user_kyt');
        $this->addSql('DROP TABLE user_questionnaire');
        $this->addSql('DROP TABLE user_questionnaire_answer');
        $this->addSql('ALTER TABLE account DROP available_browser_notifications');
        $this->addSql('ALTER TABLE account_operation DROP browser_notifications');
        $this->addSql('ALTER TABLE kpi DROP answer_counter, DROP question_counter, DROP questionnaire_counter, DROP retention_counter, DROP user_kyt_counter, DROP user_questionnaire_counter, DROP user_questionnaire_answer_counter');
        $this->addSql('ALTER TABLE promotion DROP browser_notifications');
        $this->addSql('ALTER TABLE reminder DROP send_to_browser');
        $this->addSql('ALTER TABLE reminder_message DROP is_read_from_browser');
        $this->addSql('DROP INDEX UNIQ_8D93D6497BA2F5EB ON user');
        $this->addSql('ALTER TABLE user DROP api_token');
        $this->addSql('ALTER TABLE user_kpi DROP efficiency11, DROP user_questionnaire_counter');
    }
}
