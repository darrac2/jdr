<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009141815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE signalement_ressource DROP FOREIGN KEY FK_9B4856F7FC6CD52A');
        $this->addSql('ALTER TABLE signalement_ressource DROP FOREIGN KEY FK_9B4856F765C5E57E');
        $this->addSql('DROP TABLE signalement');
        $this->addSql('DROP TABLE signalement_ressource');
        $this->addSql('ALTER TABLE ressource DROP INDEX UNIQ_939F454412469DE2, ADD INDEX IDX_939F454412469DE2 (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE signalement (id INT AUTO_INCREMENT NOT NULL, nb INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE signalement_ressource (signalement_id INT NOT NULL, ressource_id INT NOT NULL, INDEX IDX_9B4856F765C5E57E (signalement_id), INDEX IDX_9B4856F7FC6CD52A (ressource_id), PRIMARY KEY(signalement_id, ressource_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE signalement_ressource ADD CONSTRAINT FK_9B4856F7FC6CD52A FOREIGN KEY (ressource_id) REFERENCES ressource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE signalement_ressource ADD CONSTRAINT FK_9B4856F765C5E57E FOREIGN KEY (signalement_id) REFERENCES signalement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ressource DROP INDEX IDX_939F454412469DE2, ADD UNIQUE INDEX UNIQ_939F454412469DE2 (category_id)');
    }
}
