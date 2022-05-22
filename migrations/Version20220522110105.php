<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522110105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gastronomia ADD CONSTRAINT FK_C4EEB6C419D7F904 FOREIGN KEY (producto_mes_id) REFERENCES producto_tipico (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C4EEB6C419D7F904 ON gastronomia (producto_mes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gastronomia DROP FOREIGN KEY FK_C4EEB6C419D7F904');
        $this->addSql('DROP INDEX UNIQ_C4EEB6C419D7F904 ON gastronomia');
    }
}
