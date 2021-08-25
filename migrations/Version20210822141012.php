<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210822141012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE saved_challenge (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE randomizer_result ADD saved_challenge_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE randomizer_result ADD CONSTRAINT FK_E4A9A3215040560 FOREIGN KEY (saved_challenge_id) REFERENCES saved_challenge (id)');
        $this->addSql('CREATE INDEX IDX_E4A9A3215040560 ON randomizer_result (saved_challenge_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE randomizer_result DROP FOREIGN KEY FK_E4A9A3215040560');
        $this->addSql('DROP TABLE saved_challenge');
        $this->addSql('DROP INDEX IDX_E4A9A3215040560 ON randomizer_result');
        $this->addSql('ALTER TABLE randomizer_result DROP saved_challenge_id');
    }
}
