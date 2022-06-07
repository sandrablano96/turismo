<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605161307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE opiniones_visitas_guiadas (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, visita_guiada_id INT NOT NULL, uid VARCHAR(36) NOT NULL, INDEX IDX_CCDBD9AEDB38439E (usuario_id), INDEX IDX_CCDBD9AEC27D5023 (visita_guiada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE opiniones_visitas_guiadas ADD CONSTRAINT FK_CCDBD9AEDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE opiniones_visitas_guiadas ADD CONSTRAINT FK_CCDBD9AEC27D5023 FOREIGN KEY (visita_guiada_id) REFERENCES visita_guiada (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE opiniones_visitas_guiadas');
    }
}
