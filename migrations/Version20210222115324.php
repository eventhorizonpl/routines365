<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210222115324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Version v6';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account CHANGE available_email_notifications available_notifications INT NOT NULL, DROP available_browser_notifications, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE account_operation CHANGE email_notifications notifications INT NOT NULL, DROP browser_notifications');
        $this->addSql('ALTER TABLE promotion CHANGE email_notifications notifications INT NOT NULL AFTER name, DROP browser_notifications');
        $this->addSql('ALTER TABLE user ADD account_id INT DEFAULT NULL AFTER uuid');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_8D93D6499B6B5FBA ON user (account_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account CHANGE available_notifications available_email_notifications INT NOT NULL, ADD available_browser_notifications INT NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE account_operation CHANGE notifications email_notifications INT NOT NULL, ADD browser_notifications INT NOT NULL');
        $this->addSql('ALTER TABLE promotion CHANGE notifications email_notifications INT NOT NULL, ADD browser_notifications INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499B6B5FBA');
        $this->addSql('DROP INDEX IDX_8D93D6499B6B5FBA ON user');
        $this->addSql('ALTER TABLE user DROP account_id');
    }
}
