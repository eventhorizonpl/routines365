<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212134313 extends AbstractMigration
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
        $this->addSql('ALTER TABLE account ADD available_notifications INT NOT NULL, DROP available_browser_notifications, DROP available_email_notifications');
        $this->addSql('ALTER TABLE account_operation ADD notifications INT NOT NULL, DROP browser_notifications, DROP email_notifications');
        $this->addSql('ALTER TABLE promotion ADD notifications INT NOT NULL, DROP browser_notifications, DROP email_notifications');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account ADD available_email_notifications INT NOT NULL, CHANGE available_notifications available_browser_notifications INT NOT NULL');
        $this->addSql('ALTER TABLE account_operation ADD email_notifications INT NOT NULL, CHANGE notifications browser_notifications INT NOT NULL');
        $this->addSql('ALTER TABLE promotion ADD email_notifications INT NOT NULL, CHANGE notifications browser_notifications INT NOT NULL');
    }
}
