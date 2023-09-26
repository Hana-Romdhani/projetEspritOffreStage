<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230923144532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, pseudo_auteur VARCHAR(50) NOT NULL, contenu VARCHAR(50) NOT NULL, date_pub DATETIME NOT NULL, INDEX IDX_67F068BC4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, nom_competence VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, place VARCHAR(255) NOT NULL, organisateur VARCHAR(255) NOT NULL, dateEv DATE NOT NULL, nombredispo INT NOT NULL, mombremax INT NOT NULL, type VARCHAR(255) DEFAULT NULL, pdfFile LONGBLOB DEFAULT NULL, image LONGBLOB DEFAULT NULL, isFavourite TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, user_idoffre_id INT NOT NULL, nom_offre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_publication DATE NOT NULL, date_cloture DATE NOT NULL, UNIQUE INDEX UNIQ_AF86866F1E5D0459 (test_id), INDEX IDX_AF86866F417ADEBB (user_idoffre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_competence (offre_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_B98A0F5A4CC8505A (offre_id), INDEX IDX_B98A0F5A15761DAB (competence_id), PRIMARY KEY(offre_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, user_id_id INT NOT NULL, INDEX IDX_AB55E24F71F7E88B (event_id), INDEX IDX_AB55E24F9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, isuser_id INT NOT NULL, titre VARCHAR(50) NOT NULL, description VARCHAR(50) NOT NULL, contenu VARCHAR(50) NOT NULL, pseudo_auteur VARCHAR(50) NOT NULL, date_pub DATETIME NOT NULL, likes INT NOT NULL, dislikes INT NOT NULL, pinned TINYINT(1) NOT NULL, INDEX IDX_5A8A6C8DE14B9C9 (isuser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_answer (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, question LONGTEXT NOT NULL, answer LONGTEXT NOT NULL, INDEX IDX_DD80652D1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, reponse_id INT DEFAULT NULL, useridid_id INT NOT NULL, date_reclamation DATE NOT NULL, description VARCHAR(255) NOT NULL, etat VARCHAR(20) NOT NULL, user VARCHAR(255) NOT NULL, test DATE DEFAULT NULL, UNIQUE INDEX UNIQ_CE606404CF18BB82 (reponse_id), INDEX IDX_CE60640435200EF0 (useridid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, date_rep DATE NOT NULL, traitement LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id_specialite INT AUTO_INCREMENT NOT NULL, domaine VARCHAR(255) NOT NULL, PRIMARY KEY(id_specialite)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (specialite_id INT DEFAULT NULL, Id_utilisateur INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, pwd VARCHAR(255) NOT NULL, numero_tel VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, url_image VARCHAR(255) NOT NULL, date DATETIME NOT NULL, isdelete TINYINT(1) NOT NULL, datederniereconnx DATETIME DEFAULT NULL, domaine_de_competence VARCHAR(255) DEFAULT NULL, tarif_horaire VARCHAR(255) DEFAULT NULL, portfolio VARCHAR(255) DEFAULT NULL, siteweb VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, forme_juridique VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, INDEX IDX_1D1C63B32195E0F0 (specialite_id), PRIMARY KEY(Id_utilisateur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F417ADEBB FOREIGN KEY (user_idoffre_id) REFERENCES utilisateur (Id_utilisateur)');
        $this->addSql('ALTER TABLE offre_competence ADD CONSTRAINT FK_B98A0F5A4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_competence ADD CONSTRAINT FK_B98A0F5A15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F9D86650F FOREIGN KEY (user_id_id) REFERENCES utilisateur (Id_utilisateur)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DE14B9C9 FOREIGN KEY (isuser_id) REFERENCES utilisateur (Id_utilisateur)');
        $this->addSql('ALTER TABLE question_answer ADD CONSTRAINT FK_DD80652D1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404CF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE60640435200EF0 FOREIGN KEY (useridid_id) REFERENCES utilisateur (Id_utilisateur)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (Id_utilisateur)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B32195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id_specialite)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC4B89032C');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F1E5D0459');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F417ADEBB');
        $this->addSql('ALTER TABLE offre_competence DROP FOREIGN KEY FK_B98A0F5A4CC8505A');
        $this->addSql('ALTER TABLE offre_competence DROP FOREIGN KEY FK_B98A0F5A15761DAB');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F71F7E88B');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F9D86650F');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DE14B9C9');
        $this->addSql('ALTER TABLE question_answer DROP FOREIGN KEY FK_DD80652D1E5D0459');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404CF18BB82');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE60640435200EF0');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B32195E0F0');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE offre_competence');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE question_answer');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
