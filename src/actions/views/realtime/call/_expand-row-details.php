<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

use yii\grid\GridView;
use yii\helpers\Html;
use maxodrom\mangooffice\models\events\Call;

/** @var \yii\data\ArrayDataProvider $dataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'columns' => [
        [
            'attribute' => 'call_id',
            'format' => 'raw',
            'header' => 'Идентификатор вызова',
            'value' => function ($model) {
                /** @var Call $model */
                return base64_decode($model->call_id);
            },
        ],
        [
            'attribute' => 'timestamp',
            'format' => 'raw',
            'header' => 'Время события',
            'value' => function ($model) {
                /** @var Call $model */
                return Yii::$app->formatter->asDatetime($model->timestamp, 'medium');
            },
        ],
        [
            'attribute' => 'seq',
            'format' => 'raw',
            'header' => 'Послед-ть',
            'value' => function ($model) {
                /** @var Call $model */
                return $model->seq;
            },
        ],
        [
            'attribute' => 'location',
            'format' => 'raw',
            'header' => 'Расположение',
            'value' => function ($model) {
                /** @var Call $model */
                return Html::tag(
                    'span',
                    Call::getLocationLabels()[$model->location],
                    [
                        'class' => 'label label-' .
                            Call::getLocationCssClass()[$model->location],
                    ]
                );
            },
        ],
        [
            'attribute' => 'all_state',
            'format' => 'raw',
            'header' => 'Состояние',
            'value' => function ($model) {
                /** @var Call $model */
                return Html::tag(
                    'span',
                    Call::getCallStateLabels()[$model->call_state],
                    [
                        'class' => 'label label-' .
                            Call::getCallStateCssClass()[$model->call_state],
                    ]
                );
            },
        ],
        [
            'attribute' => 'to_number',
            'format' => 'raw',
            'header' => 'Номер вызываемого абонента',
            'value' => function ($model) {
                /** @var Call $model */
                return $model->to_number;
            },
        ],
        [
            'attribute' => 'disconnect_reason',
            'format' => 'raw',
            'header' => 'Причина завершения вызова',
            'value' => function ($model) {
                /** @var Call $model */
                return $model->disconnect_reason != null ?
                    Html::tag(
                        'span',
                        $model->disconnect_reason,
                        [
                            'class' => 'label label-primary',
                            'title' => Call::$resultStatuses[$model->disconnect_reason],
                        ]
                    ) : '';
            },
        ],
    ],
]);
