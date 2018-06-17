<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\mangooffice\actions\realtime\summary;

use yii\data\ActiveDataProvider;
use maxodrom\mangooffice\actions\BaseAction;
use maxodrom\mangooffice\models\events\Summary;

/**
 * Class IndexAction
 *
 * @package maxodrom\mangooffice\actions\realtime\summary
 */
class IndexAction extends BaseAction
{
    public $viewFile = '@mangooffice/actions/views/realtime/index';

    /**
     * @return string
     */
    public function run()
    {
        $dataProvider = new ActiveDataProvider([
            'query' =>
                Summary::find()
                    ->orderBy([
                        'id' => SORT_DESC,
                    ])
        ]);

        return $this->controller->render($this->viewFile, [
            'dataProvider' => $dataProvider,
        ]);
    }
}