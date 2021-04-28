<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210418193518 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id_formation INT NOT NULL, id_etudiant INT NOT NULL, INDEX IDX_351268BBC0759D98 (id_formation), INDEX IDX_351268BB21A5CE76 (id_etudiant), PRIMARY KEY(id_formation, id_etudiant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBC0759D98 FOREIGN KEY (id_formation) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BB21A5CE76 FOREIGN KEY (id_etudiant) REFERENCES user (id)');
        $this->addSql('ALTER TABLE blog CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C01551436B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE discussion CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F62D4C465 FOREIGN KEY (id_user1) REFERENCES user (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FFBDD95DF FOREIGN KEY (id_user2) REFERENCES user (id)');
        $this->addSql('ALTER TABLE formation CHANGE id_formateur id_formateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF6D43C268 FOREIGN KEY (id_formateur) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message CHANGE id_user_emetteur id_user_emetteur INT DEFAULT NULL, CHANGE id_discussion id_discussion INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F653379D8 FOREIGN KEY (id_discussion) REFERENCES discussion (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F5B8412B3 FOREIGN KEY (id_user_emetteur) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14535F620E FOREIGN KEY (id_test) REFERENCES test (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1421A5CE76 FOREIGN KEY (id_etudiant) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AB55E24F6B3CA4B ON participation (id_user)');
        $this->addSql('ALTER TABLE participation ADD PRIMARY KEY (id_evenement, id_user)');
        $this->addSql('ALTER TABLE post CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE questionquiz CHANGE id_quiz id_quiz INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questionquiz ADD CONSTRAINT FK_D96D02102F32E690 FOREIGN KEY (id_quiz) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE questiontest CHANGE id_test id_test INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questiontest ADD CONSTRAINT FK_A500868E535F620E FOREIGN KEY (id_test) REFERENCES test (id)');

        $this->addSql('ALTER TABLE reclamation CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE id_user_rec id_user_rec INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404DFC84732 FOREIGN KEY (id_user_rec) REFERENCES user (id)');
        $this->addSql('ALTER TABLE slide CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE id_formation id_formation INT DEFAULT NULL');
        $this->addSql('ALTER TABLE slide ADD CONSTRAINT FK_72EFEE62C0759D98 FOREIGN KEY (id_formation) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE test CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE id_formateur id_formateur INT DEFAULT NULL, CHANGE id_formation id_formation INT DEFAULT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CC0759D98 FOREIGN KEY (id_formation) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C6D43C268 FOREIGN KEY (id_formateur) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C01551436B3CA4B');
        $this->addSql('ALTER TABLE blog CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F62D4C465');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FFBDD95DF');
        $this->addSql('ALTER TABLE discussion CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF6D43C268');
        $this->addSql('ALTER TABLE formation CHANGE id_formateur id_formateur INT NOT NULL');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F653379D8');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F5B8412B3');
        $this->addSql('ALTER TABLE message CHANGE id_discussion id_discussion INT NOT NULL, CHANGE id_user_emetteur id_user_emetteur INT NOT NULL');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14535F620E');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1421A5CE76');
        $this->addSql('ALTER TABLE note CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F6B3CA4B');
        $this->addSql('DROP INDEX IDX_AB55E24F6B3CA4B ON participation');
        $this->addSql('ALTER TABLE participation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE participation ADD PRIMARY KEY (id_user, id_evenement)');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D6B3CA4B');
        $this->addSql('ALTER TABLE post CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE questionquiz DROP FOREIGN KEY FK_D96D02102F32E690');
        $this->addSql('ALTER TABLE questionquiz CHANGE id_quiz id_quiz INT NOT NULL');
        $this->addSql('ALTER TABLE questiontest DROP FOREIGN KEY FK_A500868E535F620E');
        $this->addSql('ALTER TABLE questiontest CHANGE id_test id_test INT NOT NULL');

        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404DFC84732');
        $this->addSql('ALTER TABLE reclamation CHANGE id id INT NOT NULL, CHANGE id_user_rec id_user_rec INT NOT NULL');
        $this->addSql('ALTER TABLE slide DROP FOREIGN KEY FK_72EFEE62C0759D98');
        $this->addSql('ALTER TABLE slide CHANGE id id INT NOT NULL, CHANGE id_formation id_formation INT NOT NULL');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0CC0759D98');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C6D43C268');
        $this->addSql('ALTER TABLE test CHANGE id id INT NOT NULL, CHANGE id_formation id_formation INT NOT NULL, CHANGE id_formateur id_formateur INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id id INT NOT NULL');
    }
}
