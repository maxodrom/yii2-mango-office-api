<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\mangooffice\controllers;

use maxodrom\mangooffice\models\events\Call;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Class EventsController
 * @package maxodrom\mangooffice\controllers
 * @since 1.0
 */
class EventsController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                [
                    'class' => 'yii\filters\ContentNegotiator',
                    'formats' => [
                        'application/x-www-form-urlencoded' => Response::FORMAT_JSON,
                        'application/json' => Response::FORMAT_JSON,
                        'application/xml' => Response::FORMAT_XML,
                    ],
                ],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $disableCsrfValidationActions = [
            'call',
        ];

        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        if (in_array($action->id, $disableCsrfValidationActions)) {
            $this->enableCsrfValidation = false;
        }

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        $post = Yii::$app->request->post();
        if (!$this->validateKey(ArrayHelper::getValue($post, 'vpbx_api_key', ''))) {
            $message = 'Get invalid api key in $_POST request.';
            Yii::error($message, __METHOD__);
            throw new \yii\web\BadRequestHttpException($message);
        }

        $sign = ArrayHelper::getValue($post, 'sign', '');
        $json = ArrayHelper::getValue($post, 'json', '');
        $builtSign = $this->buildSign($json);
        if (!$this->checkSign($json, $sign)) {
            $message = 'Get invalid sign in $_POST request. Sign should be: ' . $builtSign;
            Yii::error($message, __METHOD__);
            throw new \yii\web\BadRequestHttpException($message);
        }

        return true; // or false to not run the action
    }

    /**
     * @return array
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionCall()
    {
        $json = Json::decode(Yii::$app->request->getBodyParam('json', '{}'));

        $model = new Call();
        $model->setAttributes([
            'entry_id' => ArrayHelper::getValue($json, 'entry_id'),
            'call_id' => ArrayHelper::getValue($json, 'call_id'),
            'timestamp' => ArrayHelper::getValue($json, 'timestamp'),
            'seq' => ArrayHelper::getValue($json, 'seq'),
            'call_state' => ArrayHelper::getValue($json, 'call_state'),
            'location' => ArrayHelper::getValue($json, 'location'),
            'from_extension' => ArrayHelper::getValue($json, 'from.extension'),
            'from_number' => ArrayHelper::getValue($json, 'from.number'),
            'from_taken_from_call_id' => ArrayHelper::getValue($json, 'from.taken_from_call_id'),
            'to_extension' => ArrayHelper::getValue($json, 'to.extension'),
            'to_number' => ArrayHelper::getValue($json, 'to.number'),
            'to_line_number' => ArrayHelper::getValue($json, 'to.line_number'),
            'to_acd_group' => ArrayHelper::getValue($json, 'to.acd_group'),
            'dct_number' => ArrayHelper::getValue($json, 'dct.number'),
            'dct_type' => ArrayHelper::getValue($json, 'dct.type'),
            'disconnect_reason' => ArrayHelper::getValue($json, 'disconnect_reason'),
            'command_id' => ArrayHelper::getValue($json, 'command_id'),
            'task_id' => ArrayHelper::getValue($json, 'task_id'),
            'callback_initiator' => ArrayHelper::getValue($json, 'callback_initiator'),
        ], false);

        if (!$model->save()) {
            $message = 'Cannot save Call model. Possible validation errors: ' . Html::errorSummary($model);
            Yii::error($message, __METHOD__);
            throw new \yii\web\ServerErrorHttpException();
        }

        return [
            'success' => true,
            'message' => 'Call notification was stored successfully.',
        ];
    }
}