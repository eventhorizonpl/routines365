<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200916193812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile ADD number_of_phone_verification_tries INT DEFAULT NULL, ADD phone_md5 VARCHAR(32) DEFAULT NULL, ADD phone_verification_code INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0F8F35EB69 ON profile (phone_md5)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8157AA0F8F35EB69 ON profile');
        $this->addSql('ALTER TABLE profile DROP number_of_phone_verification_tries, DROP phone_md5, DROP phone_verification_code');
    }
}
