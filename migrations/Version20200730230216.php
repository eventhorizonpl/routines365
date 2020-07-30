<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200730230216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4D17F50A6 ON account (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BFB7E36D17F50A6 ON account_operation (uuid)');
        $this->addSql('CREATE INDEX type_idx ON account_operation (type)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCDCEB2ED17F50A6 ON goal (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CFBDFA14D17F50A6 ON note (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0FD17F50A6 ON profile (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6B71CBF4D17F50A6 ON quote (uuid)');
        $this->addSql('CREATE INDEX string_length_idx ON quote (string_length)');
        $this->addSql('CREATE INDEX type_idx ON quote (type)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_40374F40D17F50A6 ON reminder (uuid)');
        $this->addSql('CREATE INDEX next_date_idx ON reminder (next_date)');
        $this->addSql('CREATE INDEX type_idx ON reminder (type)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4BF6D8D6D17F50A6 ON routine (uuid)');
        $this->addSql('CREATE INDEX type_idx ON routine (type)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D17F50A6 ON user (uuid)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_7D3656A4D17F50A6 ON account');
        $this->addSql('DROP INDEX UNIQ_3BFB7E36D17F50A6 ON account_operation');
        $this->addSql('DROP INDEX type_idx ON account_operation');
        $this->addSql('DROP INDEX UNIQ_FCDCEB2ED17F50A6 ON goal');
        $this->addSql('DROP INDEX UNIQ_CFBDFA14D17F50A6 ON note');
        $this->addSql('DROP INDEX UNIQ_8157AA0FD17F50A6 ON profile');
        $this->addSql('DROP INDEX UNIQ_6B71CBF4D17F50A6 ON quote');
        $this->addSql('DROP INDEX string_length_idx ON quote');
        $this->addSql('DROP INDEX type_idx ON quote');
        $this->addSql('DROP INDEX UNIQ_40374F40D17F50A6 ON reminder');
        $this->addSql('DROP INDEX next_date_idx ON reminder');
        $this->addSql('DROP INDEX type_idx ON reminder');
        $this->addSql('DROP INDEX UNIQ_4BF6D8D6D17F50A6 ON routine');
        $this->addSql('DROP INDEX type_idx ON routine');
        $this->addSql('DROP INDEX UNIQ_8D93D649D17F50A6 ON user');
    }
}
