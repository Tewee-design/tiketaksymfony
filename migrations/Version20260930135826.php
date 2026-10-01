<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260930135826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Table utilisateur
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql("INSERT INTO user (email, roles, password) VALUES ('skillandyou@tiketak.local', '[]', '\$2y\$13\$l2Cqi5Kcv4fuDE6yYUJaou81Vita9Z2rKXDsqWbL8Xf/fd6fMhEMu')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
    }
}
