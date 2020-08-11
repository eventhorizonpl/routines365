<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200812201103 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reminder_message (id INT AUTO_INCREMENT NOT NULL, reminder_id INT NOT NULL, content VARCHAR(512) NOT NULL, post_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', type VARCHAR(10) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_18A77923D17F50A6 (uuid), INDEX IDX_18A77923D987BE75 (reminder_id), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reminder_message ADD CONSTRAINT FK_18A77923D987BE75 FOREIGN KEY (reminder_id) REFERENCES reminder (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reminder_message');
    }
}
