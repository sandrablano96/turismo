<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515175541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patrimonio ADD tipo_id INT NOT NULL');
        $this->addSql('ALTER TABLE patrimonio ADD CONSTRAINT FK_B516657A9276E6C FOREIGN KEY (tipo_id) REFERENCES tipo_patrimonio (id)');
        $this->addSql('CREATE INDEX IDX_B516657A9276E6C ON patrimonio (tipo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patrimonio DROP FOREIGN KEY FK_B516657A9276E6C');
        $this->addSql('DROP INDEX IDX_B516657A9276E6C ON patrimonio');
        $this->addSql('ALTER TABLE patrimonio DROP tipo_id');
    }
}
