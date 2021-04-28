<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210418193931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE id_formateur id_formateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA926D43C268 FOREIGN KEY (id_formateur) REFERENCES user (id)');
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
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA926D43C268');
        $this->addSql('ALTER TABLE quiz CHANGE id id INT NOT NULL, CHANGE id_formateur id_formateur INT NOT NULL');
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
