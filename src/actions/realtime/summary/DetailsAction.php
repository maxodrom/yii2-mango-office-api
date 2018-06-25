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
use maxodrom\mangooffice\models\events\Call;

/**
 * Class DetailsAction
 *
 * @package maxodrom\mangooffice\actions\realtime\summary
 */
class DetailsAction extends BaseAction
{
    public $viewFile = '@mangooffice/actions/views/realtime/summary/details';

    /**
     * @param string $entryId
     *
     * @return string
     */
    public function run($entryId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Call::find()
                ->where(['=', 'entry_id', $entryId])
        ]);

        return $this->controller->render($this->viewFile, [
            'dataProvider' => $dataProvider,
        ]);
    }
}