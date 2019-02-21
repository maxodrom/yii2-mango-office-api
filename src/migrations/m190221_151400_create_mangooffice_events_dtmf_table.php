<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

use maxodrom\mangooffice\migrations\Migration;

/**
 * Class m190221_151400_create_mangooffice_events_dtmf_table
 */
class m190221_151400_create_mangooffice_events_dtmf_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<SQL
CREATE TABLE `mangooffice_events_dtmf` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`seq` SMALLINT(6) NULL DEFAULT NULL,
	`dtmf` VARCHAR(128) NULL DEFAULT NULL,
	`timestamp` INT(11) UNSIGNED NULL DEFAULT NULL,
	`call_id` VARCHAR(128) NULL DEFAULT NULL,
	`entry_id` VARCHAR(128) NULL DEFAULT NULL,
	`location` VARCHAR(128) NULL DEFAULT NULL,
	`initiator` VARCHAR(64) NULL DEFAULT NULL,
	`from_number` VARCHAR(64) NULL DEFAULT NULL,
	`to_number` VARCHAR(64) NULL DEFAULT NULL,
	`line_number` VARCHAR(64) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `entry_id` (`entry_id`),
	INDEX `timestamp` (`timestamp`),
	INDEX `initiator` (`initiator`),
	INDEX `from_number` (`from_number`),
	INDEX `to_number` (`to_number`),
	INDEX `line_number` (`line_number`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
SQL;
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('mangooffice_events_dtmf');
    }
}