<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\mangooffice\models\events;

use Yii;

/**
 * This is the model class for table "{{%events_call}}".
 *
 * @property int $id ID
 * @property string $entry_id Идентификатор группы вызовов
 * @property string $call_id Идентификатор вызова (плеча вызова)
 * @property int $timestamp Время события UTC
 * @property int $seq Счетчик последовательности уведомлений по вызову
 * @property string $call_state Текущее состояние вызова
 * @property string $location Текущее расположение вызова в ВАТС
 * @property string $from_extension Идентификатор сотрудника ВАТС для вызывающего абонента
 * @property string $from_number Номер вызывающего абонента
 * @property string $from_taken_from_call_id Идентификатор вызова, в котором участвовал вызывающий абонент, до того, как был переведен в текущий вызов
 * @property string $to_extension Идентификатор сотрудника ВАТС для вызываемого абонента
 * @property string $to_number Номер вызываемого абонента
 * @property string $to_line_number Входящая линия ВАТС, на которую поступил вызов
 * @property string $to_acd_group Идентификатор группы операторов ВАТС (внутренний номер группы)
 * @property string $dct_number Номер коллтрекинга (динамический или статический)
 * @property int $dct_type Тип номера коллтрекинга
 * @property string $disconnect_reason Причина завершения вызова
 * @property string $command_id Идентификатор команды внешней системы, в результате которой появился вызов
 * @property string $task_id Идентификатор задачи исходящего обзвона, в результате которой появился вызов
 * @property string $callback_initiator Инициатор обратного звонка, в результате которого появился вызов
 * @since 1.0
 */
class Call extends \yii\db\ActiveRecord
{
    /**
     * Class constants.
     */
    const CALL_STATE_APPEARED = 'Appeared';
    const CALL_STATE_CONNECTED = 'Connected';
    const CALL_STATE_DISCONNECTED = 'Disconnected';
    const CALL_STATE_ON_HOLD = 'OnHold';
    const LOCATION_IVR = 'ivr';
    const LOCATION_QUEUE = 'queue';
    const LOCATION_ABONENT = 'abonent';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%events_call}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timestamp', 'seq', 'dct_type'], 'integer'],
            [
                [
                    'entry_id',
                    'call_id',
                    'from_taken_from_call_id',
                    'to_acd_group',
                    'dct_number',
                    'command_id',
                    'task_id',
                    'callback_initiator',
                ],
                'string',
                'max' => 128,
            ],
            [
                ['call_state', 'from_extension', 'to_extension', 'to_number', 'to_line_number'],
                'string',
                'max' => 16,
            ],
            [
                'from_number',
                'string',
                'max' => 32,
            ],
            [['location'], 'string', 'max' => 7],
            [['disconnect_reason'], 'integer'],
            [
                'call_state',
                'in',
                'range' => [
                    self::CALL_STATE_APPEARED,
                    self::CALL_STATE_CONNECTED,
                    self::CALL_STATE_DISCONNECTED,
                    self::CALL_STATE_ON_HOLD,
                ],
            ],
            [
                'location',
                'in',
                'range' => [
                    self::LOCATION_IVR,
                    self::LOCATION_ABONENT,
                    self::LOCATION_QUEUE,
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entry_id' => 'Идентификатор группы вызовов',
            'call_id' => 'Идентификатор вызова (плеча вызова)',
            'timestamp' => 'Время события UTC',
            'seq' => 'Счетчик последовательности уведомлений по вызову',
            'call_state' => 'Текущее состояние вызова',
            'location' => 'Текущее расположение вызова в ВАТС',
            'from_extension' => 'Идентификатор сотрудника ВАТС для вызывающего абонента',
            'from_number' => 'Номер вызывающего абонента',
            'from_taken_from_call_id' => 'Идентификатор вызова, в котором участвовал вызывающий абонент, до того, как был переведен в текущий вызов',
            'to_extension' => 'Идентификатор сотрудника ВАТС для вызываемого абонента',
            'to_number' => 'Номер вызываемого абонента',
            'to_line_number' => 'Входящая линия ВАТС, на которую поступил вызов',
            'to_acd_group' => 'Идентификатор группы операторов ВАТС (внутренний номер группы)',
            'dct_number' => 'Номер коллтрекинга (динамический или статический)',
            'dct_type' => 'Тип номера коллтрекинга',
            'disconnect_reason' => 'Причина завершения вызова',
            'command_id' => 'Идентификатор команды внешней системы, в результате которой появился вызов',
            'task_id' => 'Идентификатор задачи исходящего обзвона, в результате которой появился вызов',
            'callback_initiator' => 'Инициатор обратного звонка, в результате которого появился вызов',
        ];
    }

    /**
     * {@inheritdoc}
     * @return CallQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CallQuery(get_called_class());
    }
}
