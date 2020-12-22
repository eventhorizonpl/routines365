<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201222121246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_kpi (id INT AUTO_INCREMENT NOT NULL, previous_user_kpi_id INT DEFAULT NULL, user_id INT NOT NULL, account_operation_counter INT NOT NULL, awarded_reward_counter INT NOT NULL, completed_goal_counter INT NOT NULL, completed_project_counter INT NOT NULL, completed_routine_counter INT NOT NULL, contact_counter INT NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', goal_counter INT NOT NULL, note_counter INT NOT NULL, project_counter INT NOT NULL, reminder_counter INT NOT NULL, reward_counter INT NOT NULL, routine_counter INT NOT NULL, saved_email_counter INT NOT NULL, type VARCHAR(8) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_4B843C52D17F50A6 (uuid), UNIQUE INDEX UNIQ_4B843C5222950A09 (previous_user_kpi_id), INDEX IDX_4B843C52A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_kpi ADD CONSTRAINT FK_4B843C5222950A09 FOREIGN KEY (previous_user_kpi_id) REFERENCES user_kpi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_kpi ADD CONSTRAINT FK_4B843C52A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_kpi DROP FOREIGN KEY FK_4B843C5222950A09');
        $this->addSql('DROP TABLE user_kpi');
    }
}
