<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611201442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento CHANGE uid uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE guia_turismo CHANGE uid uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE historia_imagenes CHANGE uid uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE museo CHANGE uid uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE oficina_turismo CHANGE uid uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE patrimonio CHANGE uid uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE pieza_museo CHANGE uid uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE producto_tipico ADD receta VARCHAR(255) NOT NULL, CHANGE uid uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE usuario CHANGE uid uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE visita_guiada CHANGE uid uid VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento CHANGE uid uid VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE guia_turismo CHANGE uid uid VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE historia_imagenes CHANGE uid uid VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE museo CHANGE uid uid VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE oficina_turismo CHANGE uid uid VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE patrimonio CHANGE uid uid VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE pieza_museo CHANGE uid uid VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE producto_tipico DROP receta, CHANGE uid uid VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE usuario CHANGE uid uid VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE visita_guiada CHANGE uid uid VARCHAR(36) NOT NULL');
    }
}
