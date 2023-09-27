<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230927134958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation ADD list_amis_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9AC205FCA FOREIGN KEY (list_amis_id) REFERENCES list_amis (id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E9AC205FCA ON conversation (list_amis_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9AC205FCA');
        $this->addSql('DROP INDEX IDX_8A8E26E9AC205FCA ON conversation');
        $this->addSql('ALTER TABLE conversation DROP list_amis_id');
    }
}
