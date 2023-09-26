<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503220800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre ADD user_idoffre_id INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F417ADEBB FOREIGN KEY (user_idoffre_id) REFERENCES utilisateur (Id_utilisateur)');
        $this->addSql('CREATE INDEX IDX_AF86866F417ADEBB ON offre (user_idoffre_id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE60640435200EF0 FOREIGN KEY (useridid_id) REFERENCES utilisateur (Id_utilisateur)');
        $this->addSql('CREATE INDEX IDX_CE60640435200EF0 ON reclamation (useridid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE60640435200EF0');
        $this->addSql('DROP INDEX IDX_CE60640435200EF0 ON reclamation');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F417ADEBB');
        $this->addSql('DROP INDEX IDX_AF86866F417ADEBB ON offre');
        $this->addSql('ALTER TABLE offre DROP user_idoffre_id');
    }
}
