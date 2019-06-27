<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190627124653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE sms_message ADD sid varchar(255) NOT NULL, ADD date_updated DATETIME, ADD date_sent DATETIME, CHANGE status status enum(\'queued\', \'sent\', \'delivered\', \'undelivered\', \'failed\'), CHANGE timestamp_sent date_created DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE sms_message ADD timestamp_sent DATETIME NOT NULL, DROP sid, DROP date_created, DROP date_updated, DROP date_sent, CHANGE status status VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
