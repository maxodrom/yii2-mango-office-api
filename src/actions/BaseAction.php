<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\mangooffice\actions;

use Yii;
use yii\base\Action;

/**
 * Class BaseAction
 *
 * @package maxodrom\mangooffice\actions
 */
class BaseAction extends Action
{
    /**
     * @var string Path to view file.
     */
    public $viewFile;
    /**
     * @var array|callable Breadcrumbs settings.
     */
    public $breadcrumbs;
    /**
     * @var string|array|callable Success URL in order to return after success action completion
     */
    public $successUrl;
    /**
     * @var string|array|callable Error URL in order to return after action fail
     */
    public $errorUrl;


    /**
     * @inheritdoc
     */
    public function init()
    {
        Yii::$app->setAliases([
            '@mangooffice' => '@vendor/maxodrom/yii2-mango-office-api/src',
        ]);

        if (is_array($this->breadcrumbs) && !empty($this->breadcrumbs)) {
            $this->controller->getView()->params['breadcrumbs'] = $this->breadcrumbs;
        }

        parent::init();
    }

    /**
     * Производит редирект, используя HTTP_REFERRER
     *
     * @return \yii\web\Response
     */
    final public function returnByReferrer()
    {
        $referrer = Yii::$app->getRequest()->getReferrer();
        if (null !== $referrer) {
            return $this->controller->redirect($referrer);
        } else {
            $url = '/';
            if ($this->controller->module->hasProperty('homeUrl')) {
                $url = $this->controller->module->homeUrl;
            }

            return $this->controller->redirect($url);
        }
    }
}