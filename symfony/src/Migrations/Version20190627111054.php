<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190627111054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE sms_message ADD status enum(\'queued\', \'sent\', \'delivered\', \'undelivered\', \'failed\'), CHANGE timestamp_sent timestamp_sent DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE sms_message DROP status, CHANGE timestamp_sent timestamp_sent DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
