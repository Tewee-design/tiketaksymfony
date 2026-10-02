<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260930200300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Conservation tickets
        $this->addSql('ALTER TABLE ticket RENAME COLUMN mail TO auteur');
        $this->addSql('ALTER TABLE ticket RENAME COLUMN date_creation TO date_ouverture');
        $this->addSql('ALTER TABLE ticket ADD COLUMN date_cloture DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE ticket DROP COLUMN date_cloture');
        $this->addSql('ALTER TABLE ticket RENAME COLUMN auteur TO mail');
        $this->addSql('ALTER TABLE ticket RENAME COLUMN date_ouverture TO date_creation');
    }
}
