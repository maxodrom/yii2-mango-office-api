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
 * Class m180617_013436_create_table_events_summary
 */
class m180617_013436_create_table_events_summary extends Migration
{
    const TABLE_NAME = '{{%events_summary}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            self::TABLE_NAME,
            [
                'id' => $this->primaryKey(11)->unsigned()->comment('ID'),
                'entry_id' => $this->string(128)->null()->comment('Идентификатор группы вызовов'),
                'call_direction' => $this->tinyInteger(1)->null()->comment('Направление вызова'),
                'from_extension' => $this->string(16)->null()->comment('Идентификатор сотрудника ВАТС для вызывающего абонента'),
                'from_number' => $this->string(32)->null()->comment('Номер вызывающего абонента'),
                'to_extension' => $this->string(16)->null()->comment('Идентификатор сотрудника ВАТС для вызываемого абонента'),
                'to_number' => $this->string(32)->null()->comment('Номер вызываемого абонента'),
                'line_number' => $this->string(16)->null()->comment('Входящая линия ВАТС, на которую поступил вызов'),
                'dct_number' => $this->string(128)->null()->comment('Номер коллтрекинга (динамический или статический)'),
                'dct_type' => $this->tinyInteger(1)->unsigned()->null()->comment('Тип номера коллтрекинга'),
                'create_time' => $this->integer(11)->unsigned()->null()->comment('Время начала входящего/исходящего звонка'),
                'forward_time' => $this->integer(11)->unsigned()->null()->comment('Время переадресации'),
                'talk_time' => $this->integer(11)->unsigned()->null()->comment('Время ответа на вызов сотрудником или внешним абонентом'),
                'end_time' => $this->integer(11)->unsigned()->null()->comment('Время завершения всего разговора'),
                'entry_result' => $this->tinyInteger(1)->unsigned()->null()->comment('Результат вызова'),
                'disconnect_reason' => $this->smallInteger(4)->unsigned()->null()->comment('Причина завершения вызова'),
            ],
            $this->getTableOptions()
        );

        $indexes = [
            'entry_id',
            'from_extension',
            'from_number',
            'to_number',
            'to_extension',
            'line_number',
            'create_time',
            'forward_time',
            'talk_time',
            'end_time',
            'disconnect_reason',
        ];

        foreach ($indexes as $index) {
            $this->createIndex(
                $index,
                self::TABLE_NAME,
                $index
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
