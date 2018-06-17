<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\mangooffice\models\events;

/**
 * This is the ActiveQuery class for [[Summary]].
 *
 * @see Summary
 */
class SummaryQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Summary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Summary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
