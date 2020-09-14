<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200904143804 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_caracteristique (service_id INT NOT NULL, caracteristique_id INT NOT NULL, INDEX IDX_F34ECE6FED5CA9E6 (service_id), INDEX IDX_F34ECE6F1704EEB7 (caracteristique_id), PRIMARY KEY(service_id, caracteristique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_caracteristique ADD CONSTRAINT FK_F34ECE6FED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_caracteristique ADD CONSTRAINT FK_F34ECE6F1704EEB7 FOREIGN KEY (caracteristique_id) REFERENCES caracteristique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE caracteristique DROP FOREIGN KEY FK_D14FBE8BED5CA9E6');
        $this->addSql('DROP INDEX IDX_D14FBE8BED5CA9E6 ON caracteristique');
        $this->addSql('ALTER TABLE caracteristique DROP service_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE service_caracteristique');
        $this->addSql('ALTER TABLE caracteristique ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE caracteristique ADD CONSTRAINT FK_D14FBE8BED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_D14FBE8BED5CA9E6 ON caracteristique (service_id)');
    }
}
