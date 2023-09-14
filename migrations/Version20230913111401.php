<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913111401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_crea DATETIME NOT NULL, ordre INT NOT NULL, UNIQUE INDEX UNIQ_852BBECDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum_commentaire (id INT AUTO_INCREMENT NOT NULL, id_forum_id INT DEFAULT NULL, user_id INT DEFAULT NULL, text LONGTEXT NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_61C4EB1E79175645 (id_forum_id), INDEX IDX_61C4EB1EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, fichier VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, status INT NOT NULL, private INT NOT NULL, date_publication DATETIME NOT NULL, UNIQUE INDEX UNIQ_939F454412469DE2 (category_id), UNIQUE INDEX UNIQ_939F4544A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE signalement (id INT AUTO_INCREMENT NOT NULL, nb INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE signalement_ressource (signalement_id INT NOT NULL, ressource_id INT NOT NULL, INDEX IDX_9B4856F765C5E57E (signalement_id), INDEX IDX_9B4856F7FC6CD52A (ressource_id), PRIMARY KEY(signalement_id, ressource_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE forum_commentaire ADD CONSTRAINT FK_61C4EB1E79175645 FOREIGN KEY (id_forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE forum_commentaire ADD CONSTRAINT FK_61C4EB1EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F454412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE signalement_ressource ADD CONSTRAINT FK_9B4856F765C5E57E FOREIGN KEY (signalement_id) REFERENCES signalement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE signalement_ressource ADD CONSTRAINT FK_9B4856F7FC6CD52A FOREIGN KEY (ressource_id) REFERENCES ressource (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECDA76ED395');
        $this->addSql('ALTER TABLE forum_commentaire DROP FOREIGN KEY FK_61C4EB1E79175645');
        $this->addSql('ALTER TABLE forum_commentaire DROP FOREIGN KEY FK_61C4EB1EA76ED395');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F454412469DE2');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544A76ED395');
        $this->addSql('ALTER TABLE signalement_ressource DROP FOREIGN KEY FK_9B4856F765C5E57E');
        $this->addSql('ALTER TABLE signalement_ressource DROP FOREIGN KEY FK_9B4856F7FC6CD52A');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE forum_commentaire');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE signalement');
        $this->addSql('DROP TABLE signalement_ressource');
    }
}
