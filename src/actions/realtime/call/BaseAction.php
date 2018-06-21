<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\mangooffice\actions\realtime\call;

use yii\web\NotFoundHttpException;
use maxodrom\mangooffice\models\events\Call;

/**
 * Class BaseAction
 *
 * @package maxodrom\mangooffice\actions\realtime\call
 */
class BaseAction extends \maxodrom\mangooffice\actions\BaseAction
{
    /**
     * Finds Call model using its id. If model can not be found
     * NotFoundHttpException will be thrown.
     *
     * @param integer $id
     *
     * @return array|\maxodrom\mangooffice\models\events\Call|null
     * @throws \yii\web\NotFoundHttpException
     */
    protected function findCallModel($id)
    {
        $model = Call::find()
            ->where(['=', '[[id]]', $id])
            ->all();
        if (null !== $model) {
            return $model;
        }

        throw new NotFoundHttpException(
            'Requested Call model was not found.'
        );
    }
}