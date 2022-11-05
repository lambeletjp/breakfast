<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221105135425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE breakfast_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE dish_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE breakfast (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN breakfast.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE breakfast_dish (breakfast_id INT NOT NULL, dish_id INT NOT NULL, PRIMARY KEY(breakfast_id, dish_id))');
        $this->addSql('CREATE INDEX IDX_1E7D803F442D22 ON breakfast_dish (breakfast_id)');
        $this->addSql('CREATE INDEX IDX_1E7D803F148EB0CB ON breakfast_dish (dish_id)');
        $this->addSql('CREATE TABLE dish (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE breakfast_dish ADD CONSTRAINT FK_1E7D803F442D22 FOREIGN KEY (breakfast_id) REFERENCES breakfast (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE breakfast_dish ADD CONSTRAINT FK_1E7D803F148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE breakfast_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE dish_id_seq CASCADE');
        $this->addSql('ALTER TABLE breakfast_dish DROP CONSTRAINT FK_1E7D803F442D22');
        $this->addSql('ALTER TABLE breakfast_dish DROP CONSTRAINT FK_1E7D803F148EB0CB');
        $this->addSql('DROP TABLE breakfast');
        $this->addSql('DROP TABLE breakfast_dish');
        $this->addSql('DROP TABLE dish');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
