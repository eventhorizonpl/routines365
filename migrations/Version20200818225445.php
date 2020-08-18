<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818225445 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_operation ADD reminder_message_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE account_operation ADD CONSTRAINT FK_3BFB7E36EA05C965 FOREIGN KEY (reminder_message_id) REFERENCES reminder_message (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BFB7E36EA05C965 ON account_operation (reminder_message_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_operation DROP FOREIGN KEY FK_3BFB7E36EA05C965');
        $this->addSql('DROP INDEX UNIQ_3BFB7E36EA05C965 ON account_operation');
        $this->addSql('ALTER TABLE account_operation DROP reminder_message_id');
    }
}
