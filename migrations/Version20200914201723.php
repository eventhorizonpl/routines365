<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200914201723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sent_reminder (id INT AUTO_INCREMENT NOT NULL, reminder_id INT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_CD45CB82D17F50A6 (uuid), INDEX IDX_CD45CB82D987BE75 (reminder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sent_reminder ADD CONSTRAINT FK_CD45CB82D987BE75 FOREIGN KEY (reminder_id) REFERENCES reminder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reminder_message ADD sent_reminder_id INT NOT NULL');
        $this->addSql('ALTER TABLE reminder_message ADD CONSTRAINT FK_18A77923AA48B189 FOREIGN KEY (sent_reminder_id) REFERENCES sent_reminder (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_18A77923AA48B189 ON reminder_message (sent_reminder_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reminder_message DROP FOREIGN KEY FK_18A77923AA48B189');
        $this->addSql('DROP TABLE sent_reminder');
        $this->addSql('DROP INDEX IDX_18A77923AA48B189 ON reminder_message');
        $this->addSql('ALTER TABLE reminder_message DROP sent_reminder_id');
    }
}
