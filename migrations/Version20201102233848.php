<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102233848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact ADD comment VARCHAR(2048) NOT NULL, ADD status VARCHAR(8) NOT NULL');
        $this->addSql('CREATE INDEX type_idx ON contact (type)');
        $this->addSql('CREATE INDEX status_idx ON contact (status)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX type_idx ON contact');
        $this->addSql('DROP INDEX status_idx ON contact');
        $this->addSql('ALTER TABLE contact DROP comment, DROP status');
    }
}
