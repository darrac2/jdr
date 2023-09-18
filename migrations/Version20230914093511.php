<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914093511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE list_amis (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_amis_id INT DEFAULT NULL, pending TINYINT(1) NOT NULL, INDEX IDX_DA2C388879F37AE5 (id_user_id), INDEX IDX_DA2C3888AEF22BB7 (id_amis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE list_amis ADD CONSTRAINT FK_DA2C388879F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE list_amis ADD CONSTRAINT FK_DA2C3888AEF22BB7 FOREIGN KEY (id_amis_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_amis DROP FOREIGN KEY FK_DA2C388879F37AE5');
        $this->addSql('ALTER TABLE list_amis DROP FOREIGN KEY FK_DA2C3888AEF22BB7');
        $this->addSql('DROP TABLE list_amis');
    }
}
