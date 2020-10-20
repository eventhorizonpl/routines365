<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200919231438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id INT NOT NULL, available_email_notifications INT NOT NULL, available_sms_notifications INT NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_7D3656A4D17F50A6 (uuid), UNIQUE INDEX UNIQ_7D3656A4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_operation (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', account_id INT NOT NULL, reminder_message_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, email_notifications INT NOT NULL, sms_notifications INT NOT NULL, type VARCHAR(8) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_3BFB7E36D17F50A6 (uuid), INDEX IDX_3BFB7E369B6B5FBA (account_id), UNIQUE INDEX UNIQ_3BFB7E36EA05C965 (reminder_message_id), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE completed_routine (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', routine_id INT NOT NULL, user_id INT NOT NULL, comment VARCHAR(255) DEFAULT NULL, minutes_devoted INT NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_CFA33B2D17F50A6 (uuid), INDEX IDX_CFA33B2F27A94C7 (routine_id), INDEX IDX_CFA33B2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cron_job (id INT AUTO_INCREMENT NOT NULL, command VARCHAR(1024) NOT NULL, description VARCHAR(191) NOT NULL, enabled TINYINT(1) NOT NULL, name VARCHAR(191) NOT NULL, schedule VARCHAR(191) NOT NULL, UNIQUE INDEX un_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cron_report (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, exit_code INT NOT NULL, output LONGTEXT NOT NULL, run_at DATETIME NOT NULL, run_time DOUBLE PRECISION NOT NULL, INDEX IDX_B6C6A7F5BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goal (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', routine_id INT NOT NULL, user_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, is_completed TINYINT(1) NOT NULL, name VARCHAR(64) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_FCDCEB2ED17F50A6 (uuid), INDEX IDX_FCDCEB2EF27A94C7 (routine_id), INDEX IDX_FCDCEB2EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kpi (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', account_counter INT NOT NULL, account_operation_counter INT NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', goal_counter INT NOT NULL, note_counter INT NOT NULL, profile_counter INT NOT NULL, quote_counter INT NOT NULL, reminder_counter INT NOT NULL, reminder_message_counter INT NOT NULL, routine_counter INT NOT NULL, sent_reminder_counter INT NOT NULL, user_counter INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_A0925DD9D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lexik_maintenance (ttl DATETIME DEFAULT NULL) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', routine_id INT DEFAULT NULL, user_id INT NOT NULL, content VARCHAR(2048) NOT NULL, title VARCHAR(255) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_CFBDFA14D17F50A6 (uuid), INDEX IDX_CFBDFA14F27A94C7 (routine_id), INDEX IDX_CFBDFA14A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id INT NOT NULL, country VARCHAR(2) DEFAULT NULL, first_name VARCHAR(64) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, last_name VARCHAR(64) DEFAULT NULL, number_of_phone_verification_tries INT DEFAULT NULL, phone VARCHAR(35) DEFAULT NULL COMMENT \'(DC2Type:phone_number)\', phone_md5 VARCHAR(32) DEFAULT NULL, phone_verification_code INT DEFAULT NULL, show_motivational_messages TINYINT(1) NOT NULL, theme VARCHAR(8) DEFAULT NULL, time_zone VARCHAR(36) DEFAULT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_8157AA0F444F97DD (phone), UNIQUE INDEX UNIQ_8157AA0F8F35EB69 (phone_md5), UNIQUE INDEX UNIQ_8157AA0FD17F50A6 (uuid), UNIQUE INDEX UNIQ_8157AA0FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quote (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', author VARCHAR(64) NOT NULL, content VARCHAR(255) NOT NULL, content_md5 VARCHAR(32) NOT NULL, is_visible TINYINT(1) NOT NULL, string_length INT NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_6B71CBF45D87BD14 (content_md5), UNIQUE INDEX UNIQ_6B71CBF4D17F50A6 (uuid), INDEX string_length_idx (string_length), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rememberme_token (series CHAR(88) UNIQUE PRIMARY KEY NOT NULL, class VARCHAR(100) NOT NULL, lastUsed DATETIME NOT NULL, username VARCHAR(200) NOT NULL, value CHAR(88) NOT NULL) COLLATE utf8mb4_bin, ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reminder (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', routine_id INT NOT NULL, user_id INT NOT NULL, hour TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', is_enabled TINYINT(1) NOT NULL, minutes_before INT NOT NULL, next_date DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', previous_date DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', send_email TINYINT(1) NOT NULL, send_motivational_message TINYINT(1) NOT NULL, send_sms TINYINT(1) NOT NULL, type VARCHAR(10) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', locked_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_40374F40D17F50A6 (uuid), INDEX IDX_40374F40F27A94C7 (routine_id), INDEX IDX_40374F40A76ED395 (user_id), INDEX next_date_idx (next_date), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reminder_message (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', reminder_id INT NOT NULL, sent_reminder_id INT NOT NULL, content VARCHAR(512) NOT NULL, post_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', third_party_system_response VARCHAR(255) DEFAULT NULL, third_party_system_type VARCHAR(10) DEFAULT NULL, type VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_18A77923D17F50A6 (uuid), INDEX IDX_18A77923D987BE75 (reminder_id), INDEX IDX_18A77923AA48B189 (sent_reminder_id), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', selector VARCHAR(20) NOT NULL, INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reward (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', routine_id INT DEFAULT NULL, user_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, is_awarded TINYINT(1) NOT NULL, name VARCHAR(64) NOT NULL, number_of_completions INT NOT NULL, required_number_of_completions INT NOT NULL, type VARCHAR(24) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_4ED17253D17F50A6 (uuid), INDEX IDX_4ED17253F27A94C7 (routine_id), INDEX IDX_4ED17253A76ED395 (user_id), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE routine (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, is_enabled TINYINT(1) NOT NULL, name VARCHAR(64) NOT NULL, type VARCHAR(16) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_4BF6D8D6D17F50A6 (uuid), INDEX IDX_4BF6D8D6A76ED395 (user_id), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sent_reminder (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', reminder_id INT NOT NULL, routine_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_CD45CB82D17F50A6 (uuid), INDEX IDX_CD45CB82D987BE75 (reminder_id), INDEX IDX_CD45CB82F27A94C7 (routine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (sid VARBINARY(128) NOT NULL PRIMARY KEY, sdata LONGBLOB NOT NULL, slifetime INTEGER UNSIGNED NOT NULL, stime INTEGER UNSIGNED NOT NULL) COLLATE utf8mb4_bin, ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', referrer_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, is_enabled TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, password VARCHAR(255) NOT NULL, referrer_code CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', type VARCHAR(8) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649A9D402B2 (referrer_code), UNIQUE INDEX UNIQ_8D93D649D17F50A6 (uuid), INDEX IDX_8D93D649798C22DB (referrer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account_operation ADD CONSTRAINT FK_3BFB7E369B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account_operation ADD CONSTRAINT FK_3BFB7E36EA05C965 FOREIGN KEY (reminder_message_id) REFERENCES reminder_message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE completed_routine ADD CONSTRAINT FK_CFA33B2F27A94C7 FOREIGN KEY (routine_id) REFERENCES routine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE completed_routine ADD CONSTRAINT FK_CFA33B2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cron_report ADD CONSTRAINT FK_B6C6A7F5BE04EA9 FOREIGN KEY (job_id) REFERENCES cron_job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EF27A94C7 FOREIGN KEY (routine_id) REFERENCES routine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F27A94C7 FOREIGN KEY (routine_id) REFERENCES routine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reminder ADD CONSTRAINT FK_40374F40F27A94C7 FOREIGN KEY (routine_id) REFERENCES routine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reminder ADD CONSTRAINT FK_40374F40A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reminder_message ADD CONSTRAINT FK_18A77923D987BE75 FOREIGN KEY (reminder_id) REFERENCES reminder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reminder_message ADD CONSTRAINT FK_18A77923AA48B189 FOREIGN KEY (sent_reminder_id) REFERENCES sent_reminder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253F27A94C7 FOREIGN KEY (routine_id) REFERENCES routine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE routine ADD CONSTRAINT FK_4BF6D8D6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sent_reminder ADD CONSTRAINT FK_CD45CB82D987BE75 FOREIGN KEY (reminder_id) REFERENCES reminder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sent_reminder ADD CONSTRAINT FK_CD45CB82F27A94C7 FOREIGN KEY (routine_id) REFERENCES routine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649798C22DB FOREIGN KEY (referrer_id) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_operation DROP FOREIGN KEY FK_3BFB7E369B6B5FBA');
        $this->addSql('ALTER TABLE cron_report DROP FOREIGN KEY FK_B6C6A7F5BE04EA9');
        $this->addSql('ALTER TABLE reminder_message DROP FOREIGN KEY FK_18A77923D987BE75');
        $this->addSql('ALTER TABLE sent_reminder DROP FOREIGN KEY FK_CD45CB82D987BE75');
        $this->addSql('ALTER TABLE account_operation DROP FOREIGN KEY FK_3BFB7E36EA05C965');
        $this->addSql('ALTER TABLE completed_routine DROP FOREIGN KEY FK_CFA33B2F27A94C7');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EF27A94C7');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F27A94C7');
        $this->addSql('ALTER TABLE reminder DROP FOREIGN KEY FK_40374F40F27A94C7');
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED17253F27A94C7');
        $this->addSql('ALTER TABLE sent_reminder DROP FOREIGN KEY FK_CD45CB82F27A94C7');
        $this->addSql('ALTER TABLE reminder_message DROP FOREIGN KEY FK_18A77923AA48B189');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A4A76ED395');
        $this->addSql('ALTER TABLE completed_routine DROP FOREIGN KEY FK_CFA33B2A76ED395');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EA76ED395');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A76ED395');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('ALTER TABLE reminder DROP FOREIGN KEY FK_40374F40A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED17253A76ED395');
        $this->addSql('ALTER TABLE routine DROP FOREIGN KEY FK_4BF6D8D6A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649798C22DB');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE account_operation');
        $this->addSql('DROP TABLE completed_routine');
        $this->addSql('DROP TABLE cron_job');
        $this->addSql('DROP TABLE cron_report');
        $this->addSql('DROP TABLE goal');
        $this->addSql('DROP TABLE kpi');
        $this->addSql('DROP TABLE lexik_maintenance');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE rememberme_token');
        $this->addSql('DROP TABLE reminder');
        $this->addSql('DROP TABLE reminder_message');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE reward');
        $this->addSql('DROP TABLE routine');
        $this->addSql('DROP TABLE sent_reminder');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE user');
    }
}
