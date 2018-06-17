<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\mangooffice\actions\realtime\summary;

use yii\web\NotFoundHttpException;
use maxodrom\mangooffice\models\events\Summary;

/**
 * Class BaseAction
 *
 * @package maxodrom\mangooffice\actions\realtime\summary
 */
class BaseAction extends \maxodrom\mangooffice\actions\BaseAction
{
    /**
     * Finds Summary model using its id. If model can not be found
     * NotFoundHttpException will be thrown.
     *
     * @param integer $id
     *
     * @return array|\maxodrom\mangooffice\models\events\Summary|null
     * @throws \yii\web\NotFoundHttpException
     */
    protected function findSummaryModel($id)
    {
        $model = Summary::find()
            ->where(['=', '[[id]]', $id])
            ->one();

        if (null !== $model) {
            return $model;
        }

        throw new NotFoundHttpException(
            'Requested Summary model was not found.'
        );
    }
}