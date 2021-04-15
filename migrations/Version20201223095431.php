<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201223095431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Version v3';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achievement (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', description VARCHAR(255) DEFAULT NULL, level INT NOT NULL, name VARCHAR(64) NOT NULL, is_enabled TINYINT(1) NOT NULL, requirement INT NOT NULL, type VARCHAR(24) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_96737FF1D17F50A6 (uuid), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', code VARCHAR(64) NOT NULL, description VARCHAR(255) DEFAULT NULL, email_notifications INT NOT NULL, expires_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', is_enabled TINYINT(1) NOT NULL, name VARCHAR(128) NOT NULL, sms_notifications INT NOT NULL, type VARCHAR(24) NOT NULL, created_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deleted_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updated_by CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_C11D7DD177153098 (code), UNIQUE INDEX UNIQ_C11D7DD1D17F50A6 (uuid), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_achievement (user_id INT NOT NULL, achievement_id INT NOT NULL, INDEX IDX_3F68B664A76ED395 (user_id), INDEX IDX_3F68B664B3EC99FE (achievement_id), PRIMARY KEY(user_id, achievement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_promotion (user_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_C1FDF035A76ED395 (user_id), INDEX IDX_C1FDF035139DF194 (promotion_id), PRIMARY KEY(user_id, promotion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_kpi (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', previous_user_kpi_id INT DEFAULT NULL, user_id INT NOT NULL, account_operation_counter INT NOT NULL, awarded_reward_counter INT NOT NULL, completed_goal_counter INT NOT NULL, completed_project_counter INT NOT NULL, completed_routine_counter INT NOT NULL, contact_counter INT NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', goal_counter INT NOT NULL, note_counter INT NOT NULL, project_counter INT NOT NULL, reminder_counter INT NOT NULL, reward_counter INT NOT NULL, routine_counter INT NOT NULL, saved_email_counter INT NOT NULL, type VARCHAR(8) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_4B843C52D17F50A6 (uuid), UNIQUE INDEX UNIQ_4B843C5222950A09 (previous_user_kpi_id), INDEX IDX_4B843C52A76ED395 (user_id), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_achievement ADD CONSTRAINT FK_3F68B664A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_achievement ADD CONSTRAINT FK_3F68B664B3EC99FE FOREIGN KEY (achievement_id) REFERENCES achievement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_promotion ADD CONSTRAINT FK_C1FDF035A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_promotion ADD CONSTRAINT FK_C1FDF035139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_kpi ADD CONSTRAINT FK_4B843C5222950A09 FOREIGN KEY (previous_user_kpi_id) REFERENCES user_kpi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_kpi ADD CONSTRAINT FK_4B843C52A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE completed_routine ADD date DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\' AFTER comment');
        $this->addSql('ALTER TABLE goal ADD completed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\' AFTER user_id');
        $this->addSql('ALTER TABLE kpi ADD achievement_counter INT NOT NULL AFTER account_operation_counter, ADD promotion_counter INT NOT NULL AFTER project_counter, ADD user_kpi_counter INT NOT NULL AFTER user_counter');
        $this->addSql('ALTER TABLE profile ADD send_weekly_monthly_statistics TINYINT(1) NOT NULL AFTER phone_verification_code');
        $this->addSql('ALTER TABLE project ADD completed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\' AFTER user_id');
        $this->addSql('ALTER TABLE quote ADD popularity INT NOT NULL AFTER is_visible');
        $this->addSql('UPDATE completed_routine SET date = updated_at');
        $this->addSql('UPDATE goal SET completed_at = updated_at WHERE is_completed = 1');
        $this->addSql('UPDATE project SET completed_at = updated_at WHERE is_completed = 1');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_achievement DROP FOREIGN KEY FK_3F68B664B3EC99FE');
        $this->addSql('ALTER TABLE user_promotion DROP FOREIGN KEY FK_C1FDF035139DF194');
        $this->addSql('ALTER TABLE user_kpi DROP FOREIGN KEY FK_4B843C5222950A09');
        $this->addSql('DROP TABLE achievement');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE user_achievement');
        $this->addSql('DROP TABLE user_promotion');
        $this->addSql('DROP TABLE user_kpi');
        $this->addSql('ALTER TABLE completed_routine DROP date');
        $this->addSql('ALTER TABLE goal DROP completed_at');
        $this->addSql('ALTER TABLE kpi DROP achievement_counter, DROP promotion_counter, DROP user_kpi_counter');
        $this->addSql('ALTER TABLE profile DROP send_weekly_monthly_statistics');
        $this->addSql('ALTER TABLE project DROP completed_at');
        $this->addSql('ALTER TABLE quote DROP popularity');
    }
}
