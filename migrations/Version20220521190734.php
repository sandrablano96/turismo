<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220521190734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historia_imagenes (id INT AUTO_INCREMENT NOT NULL, historia_id INT NOT NULL, uid VARCHAR(20) NOT NULL, archivo VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, INDEX IDX_572F00C3F8FA80EF (historia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historia_imagenes ADD CONSTRAINT FK_572F00C3F8FA80EF FOREIGN KEY (historia_id) REFERENCES historia (id)');
        $this->addSql('DROP TABLE historia_galeria');
        $this->addSql('ALTER TABLE evento ADD imagen VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE guia_turismo ADD imagen VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE museo ADD imagen VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE patrimonio ADD imagen VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE producto_tipico ADD imagen VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historia_galeria (id INT AUTO_INCREMENT NOT NULL, historia_id INT NOT NULL, uid VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, archivo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, alt VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6CFEC616F8FA80EF (historia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE historia_galeria ADD CONSTRAINT FK_6CFEC616F8FA80EF FOREIGN KEY (historia_id) REFERENCES historia (id)');
        $this->addSql('DROP TABLE historia_imagenes');
        $this->addSql('ALTER TABLE evento DROP imagen');
        $this->addSql('ALTER TABLE guia_turismo DROP imagen');
        $this->addSql('ALTER TABLE museo DROP imagen');
        $this->addSql('ALTER TABLE patrimonio DROP imagen');
        $this->addSql('ALTER TABLE producto_tipico DROP imagen');
    }
}
