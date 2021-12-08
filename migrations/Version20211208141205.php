<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211208141205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Version v13';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lock_keys (key_id VARCHAR(64) NOT NULL PRIMARY KEY, key_expiration INTEGER UNSIGNED NOT NULL, key_token VARCHAR(44) NOT NULL) COLLATE utf8mb4_bin, ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE lock_keys');
    }
}
