<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221105170308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE review (id INT NOT NULL, breakfast_id INT NOT NULL, email VARCHAR(255) NOT NULL, grade INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_794381C6442D22 ON review (breakfast_id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6442D22 FOREIGN KEY (breakfast_id) REFERENCES breakfast (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8A0F4458989D9B62 ON breakfast (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957D8CB8989D9B62 ON dish (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE review_id_seq CASCADE');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C6442D22');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP INDEX UNIQ_957D8CB8989D9B62');
        $this->addSql('DROP INDEX UNIQ_8A0F4458989D9B62');
    }
}
