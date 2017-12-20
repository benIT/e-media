<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * session table creation
 * @see https://symfony.com/doc/current/doctrine/pdo_session_storage.html
 */
class Version20171207094040 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */

    public function up(Schema $schema)
    {
        $dbPlatform = $this->connection->getDatabasePlatform()->getName();
        $this->abortIf(!in_array($dbPlatform, ['mysql', 'postgresql']), 'Migration can only be executed safely on \'mysql\' or \'postgresql\'.');
        if ($dbPlatform === 'mysql') {
            $this->addSql('
            CREATE TABLE `sessions` (
                    `sess_id` VARCHAR(128) NOT NULL PRIMARY KEY,
                    `sess_data` BLOB NOT NULL,
                    `sess_time` INTEGER UNSIGNED NOT NULL,
                    `sess_lifetime` MEDIUMINT NOT NULL
                ) COLLATE utf8_bin, ENGINE = InnoDB;
        ');
        } elseif ($dbPlatform === 'postgresql') {
            $this->addSql('
            CREATE TABLE sessions (
                sess_id VARCHAR(128) NOT NULL PRIMARY KEY,
                sess_data BYTEA NOT NULL,
                sess_time INTEGER NOT NULL,
                sess_lifetime INTEGER NOT NULL
            );
        ');
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
