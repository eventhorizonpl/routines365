<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200830234610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD referrer_id INT DEFAULT NULL, ADD referrer_code CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649798C22DB FOREIGN KEY (referrer_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A9D402B2 ON user (referrer_code)');
        $this->addSql('CREATE INDEX IDX_8D93D649798C22DB ON user (referrer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649798C22DB');
        $this->addSql('DROP INDEX UNIQ_8D93D649A9D402B2 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649798C22DB ON user');
        $this->addSql('ALTER TABLE user DROP referrer_id, DROP referrer_code');
    }
}
