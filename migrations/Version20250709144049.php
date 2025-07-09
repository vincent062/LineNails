<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250709144049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE configurations_site (id INT AUTO_INCREMENT NOT NULL, id_config INT NOT NULL, adresse_postale VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, email_contact VARCHAR(255) NOT NULL, horaires_ouverture LONGTEXT NOT NULL, url_page_facebook VARCHAR(255) NOT NULL, url_page_instgram VARCHAR(255) NOT NULL, url_prise_rdv_facebook VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE configurations_site');
    }
}
