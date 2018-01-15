<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180106175543 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE house ADD x SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE house ADD y SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE house DROP price');
        $this->addSql('ALTER TABLE house DROP price2');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE house ADD price NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE house ADD price2 NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE house DROP x');
        $this->addSql('ALTER TABLE house DROP y');
    }
}
