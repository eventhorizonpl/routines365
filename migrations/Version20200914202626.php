<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200914202626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sent_reminder ADD routine_id INT NOT NULL');
        $this->addSql('ALTER TABLE sent_reminder ADD CONSTRAINT FK_CD45CB82F27A94C7 FOREIGN KEY (routine_id) REFERENCES routine (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_CD45CB82F27A94C7 ON sent_reminder (routine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sent_reminder DROP FOREIGN KEY FK_CD45CB82F27A94C7');
        $this->addSql('DROP INDEX IDX_CD45CB82F27A94C7 ON sent_reminder');
        $this->addSql('ALTER TABLE sent_reminder DROP routine_id');
    }
}
