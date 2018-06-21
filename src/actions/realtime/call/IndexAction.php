<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\mangooffice\actions\realtime\call;

use yii\data\ActiveDataProvider;
use maxodrom\mangooffice\models\events\Call;
use yii\db\Expression;

/**
 * Class IndexAction
 *
 * @package maxodrom\mangooffice\actions\realtime\call
 */
class IndexAction extends BaseAction
{
    public $viewFile = '@mangooffice/actions/views/realtime/call/index';

    /**
     * @return string
     */
    public function run()
    {
        $dataProvider = new ActiveDataProvider([
            'query' =>
                Call::find()
                    ->select([
                        'timestamp' => new Expression('MIN(c.timestamp)'),
                        'entry_id',
                        'call_id',
                        'seq',
                        'call_state',
                        'location',
                        'from_extension',
                        'from_number',
                        'from_taken_from_call_id',
                        'to_extension',
                        'to_number',
                        'to_line_number',
                        'to_acd_group',
                        'dct_number',
                        'dct_type',
                        'disconnect_reason',
                        'command_id',
                        'task_id',
                        'callback_initiator',
                    ])
                    ->alias('c')
                    ->groupBy([
                        'c.entry_id',
                    ])
                    ->orderBy([
                        'c.id' => SORT_DESC,
                    ])
                    ->having(new Expression('MIN(c.timestamp)')),
        ]);

        return $this->controller->render($this->viewFile, [
            'dataProvider' => $dataProvider,
        ]);
    }
}