<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518111928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE museo ADD web VARCHAR(200) DEFAULT NULL, ADD email VARCHAR(200) DEFAULT NULL, CHANGE horario horario VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE patrimonio CHANGE precio precio VARCHAR(255) DEFAULT NULL, CHANGE horario horario VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE visita_guiada DROP FOREIGN KEY FK_9EE3B5069AE43F24');
        $this->addSql('ALTER TABLE visita_guiada DROP FOREIGN KEY FK_9EE3B506885190CA');
        $this->addSql('DROP INDEX IDX_9EE3B506885190CA ON visita_guiada');
        $this->addSql('DROP INDEX IDX_9EE3B5069AE43F24 ON visita_guiada');
        $this->addSql('ALTER TABLE visita_guiada ADD oficina_turismo_id INT DEFAULT NULL, ADD guia_turismo_id INT DEFAULT NULL, DROP oficina_turismo, DROP guia_turismo');
        $this->addSql('ALTER TABLE visita_guiada ADD CONSTRAINT FK_9EE3B50638B44BF5 FOREIGN KEY (oficina_turismo_id) REFERENCES oficina_turismo (id)');
        $this->addSql('ALTER TABLE visita_guiada ADD CONSTRAINT FK_9EE3B506126B4642 FOREIGN KEY (guia_turismo_id) REFERENCES guia_turismo (id)');
        $this->addSql('CREATE INDEX IDX_9EE3B50638B44BF5 ON visita_guiada (oficina_turismo_id)');
        $this->addSql('CREATE INDEX IDX_9EE3B506126B4642 ON visita_guiada (guia_turismo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE museo DROP web, DROP email, CHANGE horario horario TEXT NOT NULL');
        $this->addSql('ALTER TABLE patrimonio CHANGE precio precio TEXT DEFAULT NULL, CHANGE horario horario TEXT NOT NULL');
        $this->addSql('ALTER TABLE visita_guiada DROP FOREIGN KEY FK_9EE3B50638B44BF5');
        $this->addSql('ALTER TABLE visita_guiada DROP FOREIGN KEY FK_9EE3B506126B4642');
        $this->addSql('DROP INDEX IDX_9EE3B50638B44BF5 ON visita_guiada');
        $this->addSql('DROP INDEX IDX_9EE3B506126B4642 ON visita_guiada');
        $this->addSql('ALTER TABLE visita_guiada ADD oficina_turismo INT DEFAULT NULL, ADD guia_turismo INT DEFAULT NULL, DROP oficina_turismo_id, DROP guia_turismo_id');
        $this->addSql('ALTER TABLE visita_guiada ADD CONSTRAINT FK_9EE3B5069AE43F24 FOREIGN KEY (guia_turismo) REFERENCES guia_turismo (id)');
        $this->addSql('ALTER TABLE visita_guiada ADD CONSTRAINT FK_9EE3B506885190CA FOREIGN KEY (oficina_turismo) REFERENCES oficina_turismo (id)');
        $this->addSql('CREATE INDEX IDX_9EE3B506885190CA ON visita_guiada (oficina_turismo)');
        $this->addSql('CREATE INDEX IDX_9EE3B5069AE43F24 ON visita_guiada (guia_turismo)');
    }
}
