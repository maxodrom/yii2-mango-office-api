<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\mangooffice;

use Yii;
use yii\base\BootstrapInterface;
use yii\db\Connection;
use yii\di\Instance;

/**
 * Class Module
 * @package maxodrom\mangooffice
 * @since 1.0
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'maxodrom\mangooffice\controllers';
    /**
     * @var \yii\db\Connection|array|string DB component.
     */
    public $db = 'db';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::class);
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $this->setAliases([
            '@mangooffice' => '@vendor/maxodrom/yii2-mango-office-api/src',
        ]);

        if ($app instanceof \yii\web\Application) {
            // do nothing
        } elseif ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'maxodrom\mangooffice\commands';
            Yii::setAlias('@maxodrom/mangooffice/commands', __DIR__ . '/commands');
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $this->db->tablePrefix = $this->id . '_';

        return true;
    }
}