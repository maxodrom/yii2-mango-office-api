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
 * Class Dtmf
 *
 * @property int $id
 * @property int $seq
 * @property string $dtmf
 * @property int $timestamp
 * @property string $call_id
 * @property string $entry_id
 * @property string $location
 * @property string $initiator
 * @property string $from_number
 * @property string $to_number
 * @property string $line_number
 * @package maxodrom\mangooffice\models\events
 */
class Dtmf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Module::getTablePrefix() . 'events_dtmf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'seq' => '',
            'dtmf' => '',
            'timestamp' => '',
            'entry_id' => '',
            'call_id' => '',
            'location' => '',
            'initiator' => '',
            'from_number' => '',
            'to_number' => '',
            'line_number' => '',
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
}