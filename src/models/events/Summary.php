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
use maxodrom\mangooffice\Module;

/**
 * This is the model class for table "mangooffice_events_summary".
 *
 * @property int $id ID
 * @property string $entry_id Идентификатор группы вызовов
 * @property int $call_direction Направление вызова
 * @property string $from_extension Идентификатор сотрудника ВАТС для вызывающего абонента
 * @property string $from_number Номер вызывающего абонента
 * @property string $to_extension Идентификатор сотрудника ВАТС для вызываемого абонента
 * @property string $to_number Номер вызываемого абонента
 * @property string $line_number Входящая линия ВАТС, на которую поступил вызов
 * @property string $dct_number Номер коллтрекинга (динамический или статический)
 * @property int $dct_type Тип номера коллтрекинга
 * @property int $create_time Время начала входящего/исходящего звонка
 * @property int $forward_time Время переадресации
 * @property int $talk_time Время ответа на вызов сотрудником или внешним абонентом
 * @property int $end_time Время завершения всего разговора
 * @property int $entry_result Результат вызова
 * @property string $disconnect_reason Причина завершения вызова
 */
class Summary extends \yii\db\ActiveRecord
{
    /**
     * Class constants.
     */
    const CALL_DIRECTION_INNER = 0;
    const CALL_DIRECTION_INCOMING = 1;
    const CALL_DIRECTION_OUTGOING = 2;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Module::getTablePrefix() . 'events_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['call_direction', 'dct_type', 'create_time', 'forward_time', 'talk_time', 'end_time', 'entry_result'],
                'integer',
            ],
            [
                'call_direction',
                'in',
                'range' => [
                    self::CALL_DIRECTION_INNER,
                    self::CALL_DIRECTION_INCOMING,
                    self::CALL_DIRECTION_OUTGOING,
                ],
            ],
            [['entry_id', 'dct_number'], 'string', 'max' => 128],
            [['from_extension', 'to_extension', 'line_number'], 'string', 'max' => 16],
            [
                ['from_number', 'to_number'],
                'string',
                'max' => 64,
            ],
            [['disconnect_reason'], 'integer'],
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
            'call_direction' => 'Направление вызова',
            'from_extension' => 'Идентификатор сотрудника ВАТС для вызывающего абонента',
            'from_number' => 'Номер вызывающего абонента',
            'to_extension' => 'Идентификатор сотрудника ВАТС для вызываемого абонента',
            'to_number' => 'Номер вызываемого абонента',
            'line_number' => 'Входящая линия ВАТС, на которую поступил вызов',
            'dct_number' => 'Номер коллтрекинга (динамический или статический)',
            'dct_type' => 'Тип номера коллтрекинга',
            'create_time' => 'Время начала входящего/исходящего звонка',
            'forward_time' => 'Время переадресации',
            'talk_time' => 'Время ответа на вызов сотрудником или внешним абонентом',
            'end_time' => 'Время завершения всего разговора',
            'entry_result' => 'Результат вызова',
            'disconnect_reason' => 'Причина завершения вызова',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SummaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SummaryQuery(get_called_class());
    }

    /**
     * @return array
     */
    final public static function getCallDirectionLabels()
    {
        return [
            self::CALL_DIRECTION_INNER => 'внутренний',
            self::CALL_DIRECTION_INCOMING => 'входящий',
            self::CALL_DIRECTION_OUTGOING => 'исходящий',
        ];
    }

    /**
     * @return array
     */
    final public static function getCallDirectionLabelsCssClasses()
    {
        return [
            self::CALL_DIRECTION_INNER => 'primary',
            self::CALL_DIRECTION_INCOMING => 'success',
            self::CALL_DIRECTION_OUTGOING => 'danger',
        ];
    }
}
