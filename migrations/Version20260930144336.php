<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260930144336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Tables tickets
        $this->addSql('CREATE TABLE categorie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(80) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497DD634A4D60759 ON categorie (libelle)');
        $this->addSql('CREATE TABLE etat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(80) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55CAF762A4D60759 ON etat (libelle)');
        $this->addSql('CREATE TABLE responsable (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_52520D07E7927C74 ON responsable (email)');
        $this->addSql("INSERT INTO categorie (libelle) VALUES ('Incident'), ('Panne'), ('Evolution'), ('Anomalie'), ('Information')");
        $this->addSql("INSERT INTO etat (libelle) VALUES ('Nouveau'), ('Ouvert'), ('Résolu'), ('Fermé')");
        $this->addSql('CREATE TEMPORARY TABLE __temp__ticket AS SELECT id, mail, description, date_creation FROM ticket');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('CREATE TABLE ticket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mail VARCHAR(180) NOT NULL, description VARCHAR(250) NOT NULL, date_creation DATETIME NOT NULL, categorie_id INTEGER NOT NULL, etat_id INTEGER NOT NULL, responsable_id INTEGER DEFAULT NULL, CONSTRAINT FK_97A0ADA3BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_97A0ADA3D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_97A0ADA353C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ticket (id, mail, description, date_creation, categorie_id, etat_id) SELECT id, mail, description, date_creation, 1, 1 FROM __temp__ticket');
        $this->addSql('DROP TABLE __temp__ticket');
        $this->addSql('CREATE INDEX IDX_97A0ADA3BCF5E72D ON ticket (categorie_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3D5E86FF ON ticket (etat_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA353C59D72 ON ticket (responsable_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ticket AS SELECT id, mail, description, date_creation FROM ticket');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('CREATE TABLE ticket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mail VARCHAR(180) NOT NULL, description VARCHAR(250) NOT NULL, date_creation DATETIME NOT NULL, categorie VARCHAR(50) NOT NULL)');
        $this->addSql('INSERT INTO ticket (id, mail, description, date_creation) SELECT id, mail, description, date_creation FROM __temp__ticket');
        $this->addSql('DROP TABLE __temp__ticket');
    }
}
