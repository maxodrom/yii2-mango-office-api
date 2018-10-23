<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

use maxodrom\mangooffice\migrations\Migration;
use maxodrom\mangooffice\models\events\Call;

/**
 * Class m181023_120800_alter_table_mangooffice_events_call
 */
class m181023_120800_alter_table_mangooffice_events_call extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(
            Call::tableName(),
            'to_line_number',
            $this->string(64)->null()->comment('Входящая линия ВАТС, на которую поступил вызов')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(
            Call::tableName(),
            'to_line_number',
            $this->string(16)->null()->comment('Входящая линия ВАТС, на которую поступил вызов')
        );
    }
}
