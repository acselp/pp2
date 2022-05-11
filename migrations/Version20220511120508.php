<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511120508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie ADD title VARCHAR(255) NOT NULL, ADD path VARCHAR(255) NOT NULL, ADD active INT NOT NULL, ADD genre_id INT NOT NULL, ADD image VARCHAR(255) NOT NULL, ADD release_year INT NOT NULL, ADD running_time INT NOT NULL, ADD country VARCHAR(255) NOT NULL, ADD short_summary VARCHAR(255) NOT NULL, ADD quality INT NOT NULL, ADD age_restriction INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie DROP title, DROP path, DROP active, DROP genre_id, DROP image, DROP release_year, DROP running_time, DROP country, DROP short_summary, DROP quality, DROP age_restriction');
    }
}
