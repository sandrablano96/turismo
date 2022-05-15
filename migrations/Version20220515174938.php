<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515174938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento ADD uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE guia_turismo ADD uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE museo ADD uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE oficina_turismo ADD uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE patrimonio ADD uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE pieza_museo ADD uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE producto_tipico ADD uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE usuario ADD uid VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE visita_guiada ADD uid VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento DROP uid');
        $this->addSql('ALTER TABLE guia_turismo DROP uid');
        $this->addSql('ALTER TABLE museo DROP uid');
        $this->addSql('ALTER TABLE oficina_turismo DROP uid');
        $this->addSql('ALTER TABLE patrimonio DROP uid');
        $this->addSql('ALTER TABLE pieza_museo DROP uid');
        $this->addSql('ALTER TABLE producto_tipico DROP uid');
        $this->addSql('ALTER TABLE usuario DROP uid');
        $this->addSql('ALTER TABLE visita_guiada DROP uid');
    }
}
