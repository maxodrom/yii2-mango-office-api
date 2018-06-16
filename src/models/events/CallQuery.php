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
 * This is the ActiveQuery class for [[Call]].
 *
 * @see \maxodrom\mangooffice\models\events\Call
 */
class CallQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Call[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Call|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
