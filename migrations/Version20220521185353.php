<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220521185353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historia_galeria (id INT AUTO_INCREMENT NOT NULL, historia_id INT NOT NULL, uid VARCHAR(20) NOT NULL, archivo VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, INDEX IDX_6CFEC616F8FA80EF (historia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historia_galeria ADD CONSTRAINT FK_6CFEC616F8FA80EF FOREIGN KEY (historia_id) REFERENCES historia (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE historia_galeria');
    }
}
