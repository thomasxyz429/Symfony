<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210112135304 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C93695200282E');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A4AEAFEA');
        $this->addSql('DROP INDEX IDX_C27C9369A4AEAFEA ON stage');
        $this->addSql('DROP INDEX IDX_C27C93695200282E ON stage');
        $this->addSql('ALTER TABLE stage ADD competences_requises VARCHAR(255) NOT NULL, ADD experience_requise VARCHAR(255) NOT NULL, DROP formation_id, DROP entreprise_id, DROP description, DROP competence_requises, DROP experience_requises, CHANGE date_debut date_debut VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stage ADD formation_id INT NOT NULL, ADD entreprise_id INT NOT NULL, ADD description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD competence_requises VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD experience_requises VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP competences_requises, DROP experience_requise, CHANGE date_debut date_debut VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93695200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_C27C9369A4AEAFEA ON stage (entreprise_id)');
        $this->addSql('CREATE INDEX IDX_C27C93695200282E ON stage (formation_id)');
    }
}
