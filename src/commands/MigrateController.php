<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\mangooffice\commands;

use yii\db\Query;
use yii\helpers\Console;

/**
 * Class MigrateController
 * @package maxodrom\mangooffice\commands
 * @since 1.0
 */
class MigrateController extends \yii\console\controllers\MigrateController
{
    public $migrationPath = '@mangooffice/migrations';

    /**
     * @inheritdoc
     */
    public function actionDown($limit = 'all')
    {
        // сразу жеинсталлируем все таблицы
        $ret = parent::actionDown('all');
        $query = new Query();
        $query->from($this->migrationTable);
        if (1 == $query->count()) {
            $tableName = $this->db->schema->getRawTableName($this->migrationTable);
            $this->stdout("Deleting migration history table \"$tableName\"...", Console::FG_YELLOW);
            $this->db->createCommand()->dropTable($this->migrationTable)->execute();
            $this->stdout("Done.\n", Console::FG_GREEN);
        }

        return $ret;
    }
}