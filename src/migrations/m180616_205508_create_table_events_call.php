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
 * Class m180616_205508_create_table_events_call
 * @since 1.0
 */
class m180616_205508_create_table_events_call extends Migration
{
    const TABLE_NAME = '{{%events_call}}';

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
                'call_id' => $this->string(128)->null()->comment('Идентификатор вызова (плеча вызова)'),
                'timestamp' => $this->integer(11)->unsigned()->null()->comment('Время события UTC'),
                'seq' => $this->smallInteger()->null()->comment('Счетчик последовательности уведомлений по вызову'),
                'call_state' => $this->string(16)->null()->comment('Текущее состояние вызова'),
                'location' => $this->string(7)->null()->comment('Текущее расположение вызова в ВАТС'),
                'from_extension' => $this->string(16)->null()->comment('Идентификатор сотрудника ВАТС для вызывающего абонента'),
                'from_number' => $this->string(32)->null()->comment('Номер вызывающего абонента'),
                'from_taken_from_call_id' => $this->string(128)->null()->comment('Идентификатор вызова, в котором участвовал вызывающий абонент, до того, как был переведен в текущий вызов'),
                'to_extension' => $this->string(16)->null()->comment('Идентификатор сотрудника ВАТС для вызываемого абонента'),
                'to_number' => $this->string(32)->null()->comment('Номер вызываемого абонента'),
                'to_line_number' => $this->string(16)->null()->comment('Входящая линия ВАТС, на которую поступил вызов'),
                'to_acd_group' => $this->string(128)->null()->comment('Идентификатор группы операторов ВАТС (внутренний номер группы)'),
                'dct_number' => $this->string(128)->null()->comment('Номер коллтрекинга (динамический или статический)'),
                'dct_type' => $this->tinyInteger(1)->unsigned()->null()->comment('Тип номера коллтрекинга'),
                'disconnect_reason' => $this->smallInteger(4)->unsigned()->null()->comment('Причина завершения вызова'),
                'command_id' => $this->string(128)->null()->comment('Идентификатор команды внешней системы, в результате которой появился вызов'),
                'task_id' => $this->string(128)->null()->comment('Идентификатор задачи исходящего обзвона, в результате которой появился вызов'),
                'callback_initiator' => $this->string(128)->comment('Инициатор обратного звонка, в результате которого появился вызов')
            ],
            $this->getTableOptions()
        );

        $indexes = [
            'entry_id',
            'call_id',
            'timestamp',
            'from_extension',
            'from_number',
            'to_number',
            'to_line_number',
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
