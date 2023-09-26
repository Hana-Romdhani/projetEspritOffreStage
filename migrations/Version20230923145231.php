<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230923145231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP competence, CHANGE user_idoffre_id user_idoffre_id INT NOT NULL');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE60640435200EF0 FOREIGN KEY (useridid_id) REFERENCES utilisateur (Id_utilisateur)');
        $this->addSql('CREATE INDEX IDX_CE60640435200EF0 ON reclamation (useridid_id)');
        $this->addSql('ALTER TABLE utilisateur DROP tarif_horaire');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD tarif_horaire VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE60640435200EF0');
        $this->addSql('DROP INDEX IDX_CE60640435200EF0 ON reclamation');
        $this->addSql('ALTER TABLE offre ADD competence VARCHAR(225) DEFAULT NULL, CHANGE user_idoffre_id user_idoffre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F71F7E88B');
    }
}
