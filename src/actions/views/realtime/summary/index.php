<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use maxodrom\mangooffice\models\events\{
    Call, Summary
};
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

/** @var \yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */

$phoneNumberUtil = PhoneNumberUtil::getInstance();

$this->title = 'Уведомления о завершении вызова';
?>
<div class="panel">
    <div class="panel-body">

        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var \maxodrom\mangooffice\models\events\Summary $model */
                        return $model->id;
                    },
                ],
                [
                    'header' => 'Информация о звонке',
                    'attribute' => 'id',
                    'format' => 'raw',
                    'value' => function ($model) use ($phoneNumberUtil) {
                        /** @var \maxodrom\mangooffice\models\events\Summary $model */

                        $fromNumberObject = $phoneNumberUtil->parse($model->from_number, 'RU');
                        $fromNumber = $phoneNumberUtil->format($fromNumberObject, PhoneNumberFormat::INTERNATIONAL);
                        $lineNumberObject = $phoneNumberUtil->parse($model->line_number, 'RU');
                        $lineNumber = $phoneNumberUtil->format($lineNumberObject, PhoneNumberFormat::INTERNATIONAL);

                        $str = Html::tag(
                            'div',
                            Html::tag(
                                'span',
                                $fromNumber,
                                [
                                    'class' => 'text-danger',
                                    'title' => $model->getAttributeLabel('from_number'),
                                ]
                            ) . ' &rarr; ' .
                            Html::tag(
                                'span',
                                Html::tag(
                                    'span',
                                    $lineNumber,
                                    [
                                        'title' => $model->getAttributeLabel('line_number'),
                                        'class' => 'text-warning',
                                    ]
                                ) . ' ' .
                                Html::tag(
                                    'small',
                                    '(' . $model->to_number . ')',
                                    [
                                        'title' => $model->getAttributeLabel('to_number'),
                                        'class' => 'text-muted',
                                    ]
                                )
                            ),
                            [
                                'class' => 'h3 mar-no text-thin',
                            ]
                        );

                        $times = [
                            'create_time' => $model->create_time,
                            'forward_time' => $model->forward_time,
                            'talk_time' => $model->talk_time,
                            'end_time' => $model->end_time,
                        ];
                        $str .= Html::tag(
                            'div',
                            Html::ul(
                                $times,
                                [
                                    'item' => function ($item, $index) use ($times, $model) {
                                        /** @var \maxodrom\mangooffice\models\events\Summary $item */
                                        return Html::tag(
                                            'li',
                                            Html::tag(
                                                'small',
                                                $model->getAttributeLabel($index) . ': ' .
                                                (
                                                $times[$index] > 0 ?
                                                    Yii::$app->formatter->asDatetime($times[$index]) : '&mdash;'
                                                ),
                                                [
                                                    'class' => 'text-muted',
                                                ]
                                            )
                                        );
                                    },
                                    'style' => 'list-style:none;padding-left:0;',
                                ]
                            ),
                            [
                                'class' => 'mar-top',
                            ]
                        );

                        return $str;
                    },
                ],
                [
                    'attribute' => 'call_direction',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var \maxodrom\mangooffice\models\events\Summary $model */
                        return Html::tag(
                            'span',
                            Summary::getCallDirectionLabels()[$model->call_direction],
                            [
                                'class' => 'label label-' .
                                    Summary::getCallDirectionLabelsCssClasses()[$model->call_direction],
                            ]
                        );
                    },
                ],
                [
                    'attribute' => 'disconnect_reason',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var \maxodrom\mangooffice\models\events\Call $model */
                        $str = $model->disconnect_reason != null ?
                            Html::tag(
                                'span',
                                $model->disconnect_reason,
                                [
                                    'class' => 'label label-primary',
                                    'title' => Call::$resultStatuses[$model->disconnect_reason],
                                ]
                            ) : '';

                        if ($model->disconnect_reason != null) {
                            $str .= ' ' . Call::$resultStatuses[$model->disconnect_reason];
                        }

                        return $str;
                    },
                ],
                [
                    'attribute' => 'entry_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var \maxodrom\mangooffice\models\events\Summary $model */
                        return Html::a(
                            !empty($model->entry_id) ? base64_decode($model->entry_id) : '',
                            ['summary-details', 'entryId' => $model->entry_id],
                            [
                                'class' => 'label label-default',
                                'target' => '_blank',
                                'data' => [
                                    'pjax' => '0',
                                ],
                            ]
                        );
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'header' => 'Действия',
                    'template' => '<div class="btn-group">{delete}</div>',
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            /** @var \maxodrom\mangooffice\models\events\Summary $model */
                            return Html::a(
                                FA::i(FA::_TRASH),
                                ['delete', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-default btn-hover-danger',
                                ]
                            );
                        },
                    ],
                    'headerOptions' => [
                        'style' => 'min-width: 100px;',
                    ],
                ],
            ],
        ]) ?>
        <?php Pjax::end(); ?>

    </div>
</div>