<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180107105637 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE house_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE built_object_id_seq');
        $this->addSql('SELECT setval(\'built_object_id_seq\', (SELECT MAX(id) FROM built_object))');
        $this->addSql('ALTER TABLE built_object ALTER id SET DEFAULT nextval(\'built_object_id_seq\')');
        $this->addSql('CREATE SEQUENCE building_id_seq');
        $this->addSql('SELECT setval(\'building_id_seq\', (SELECT MAX(id) FROM building))');
        $this->addSql('ALTER TABLE building ALTER id SET DEFAULT nextval(\'building_id_seq\')');
        $this->addSql('ALTER TABLE building ALTER category SET NOT NULL');
        $this->addSql('ALTER TABLE building ALTER price SET NOT NULL');
        $this->addSql('CREATE SEQUENCE tile_id_seq');
        $this->addSql('SELECT setval(\'tile_id_seq\', (SELECT MAX(id) FROM tile))');
        $this->addSql('ALTER TABLE tile ALTER id SET DEFAULT nextval(\'tile_id_seq\')');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE house_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE building ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE building ALTER category DROP NOT NULL');
        $this->addSql('ALTER TABLE building ALTER price DROP NOT NULL');
        $this->addSql('ALTER TABLE built_object ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE tile ALTER id DROP DEFAULT');
    }
}
