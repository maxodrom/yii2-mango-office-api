<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\mangooffice\controllers;

use yii\web\Controller;

/**
 * Class BaseController
 * @package maxodrom\mangooffice\controllers
 * @property \maxodrom\mangooffice\Module $module
 * @since 1.0
 */
abstract class BaseController extends Controller
{
    /**
     * @param string $key
     *
     * @return bool
     */
    final protected function validateKey($key)
    {
        return $this->module->apiKey === $key;
    }

    /**
     * Создание подписи (sign/hash).
     *
     * @param string $json
     *
     * @return string
     */
    final protected function buildSign($json)
    {
        // алгоритм формирования подписи
        // sha256(vpbx_api_key + jsonDataString + vpbx_api_salt);
        return hash('sha256', $this->module->apiKey . $json . $this->module->apiSalt);
    }

    /**
     * Проверка подписи по данным.
     *
     * @param string $data
     * @param string $sign
     *
     * @return bool
     */
    final protected function checkSign($data, $sign)
    {
        $builtSign = $this->buildSign($data);

        return $builtSign === $sign;
    }
}