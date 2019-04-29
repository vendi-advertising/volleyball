<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190429183924 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, game_night_id INT NOT NULL, INDEX IDX_232B318CD4C7B377 (game_night_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_team (game_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_2FF5CA33E48FD905 (game_id), INDEX IDX_2FF5CA33296CD8AE (team_id), PRIMARY KEY(game_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CD4C7B377 FOREIGN KEY (game_night_id) REFERENCES game_night (id)');
        $this->addSql('ALTER TABLE game_team ADD CONSTRAINT FK_2FF5CA33E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_team ADD CONSTRAINT FK_2FF5CA33296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game_team DROP FOREIGN KEY FK_2FF5CA33E48FD905');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_team');
    }
}
