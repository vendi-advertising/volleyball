<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190429173902 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE day_of_week (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_night (id INT AUTO_INCREMENT NOT NULL, game_week_id INT NOT NULL, week_number SMALLINT NOT NULL, INDEX IDX_23E976185DAD4400 (game_week_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_week (id INT AUTO_INCREMENT NOT NULL, week_number SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, day_of_week_id INT NOT NULL, name VARCHAR(255) NOT NULL, team_number SMALLINT NOT NULL, INDEX IDX_C4E0A61F139A4A41 (day_of_week_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_night ADD CONSTRAINT FK_23E976185DAD4400 FOREIGN KEY (game_week_id) REFERENCES game_week (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F139A4A41 FOREIGN KEY (day_of_week_id) REFERENCES day_of_week (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F139A4A41');
        $this->addSql('ALTER TABLE game_night DROP FOREIGN KEY FK_23E976185DAD4400');
        $this->addSql('DROP TABLE day_of_week');
        $this->addSql('DROP TABLE game_night');
        $this->addSql('DROP TABLE game_week');
        $this->addSql('DROP TABLE team');
    }
}
