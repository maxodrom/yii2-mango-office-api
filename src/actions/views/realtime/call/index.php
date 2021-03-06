<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

use yii\grid\ActionColumn;
use yii\widgets\Pjax;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use maxodrom\mangooffice\models\events\Call;
use kartik\grid\GridView;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

/** @var \yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */

$phoneNumberUtil = PhoneNumberUtil::getInstance();

$this->title = 'Детализация звонков';

$this->registerCss(<<<CSS
.kv-expand-detail-row td[colspan] {
    background-color: #424957 !important;
    padding: 12px !important;
}
table .table {
    background-color: transparent !important;
}
CSS
);
?>
<div class="panel">
    <div class="panel-body">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'pjax' => false,
            'bordered' => true,
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'hover' => true,
            'columns' => [
                [
                    'attribute' => 'entry_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var \maxodrom\mangooffice\models\events\Call $model */
                        return base64_decode($model->entry_id);
                    },
                    'headerOptions' => [
                        'style' => 'width:200px;',
                    ],
                ],
                [
                    'attribute' => 'timestamp',
                    'header' => 'Начало звонка',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var \maxodrom\mangooffice\models\events\Call $model */
                        return Yii::$app->formatter->asDatetime($model->timestamp);
                    },
                    'headerOptions' => [
                        'style' => 'width:200px;',
                    ],
                ],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'expandIcon' => '<span class="fa fa-eye"></span>',
                    'collapseIcon' => '<span class="fa fa-eye-slash"></span>',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail' => function ($model, $key, $index, $column) {
                        /** @var \maxodrom\mangooffice\models\events\Call $model */
                        $dataProvider = new \yii\data\ArrayDataProvider([
                            'allModels' => Call::find()
                                ->where(['=', '[[entry_id]]', $model->entry_id])
                                ->orderBy([
                                    'timestamp' => SORT_ASC,
                                ])
                                ->all(),
                            'pagination' => [
                                'pageSize' => 0, // infinite (all items)
                            ],
                        ]);

                        return Yii::$app->controller->renderPartial(
                            '@mangooffice/actions/views/realtime/call/_expand-row-details',
                            [
                                'dataProvider' => $dataProvider,
                            ]
                        );
                    },
                    'enableRowClick' => false,
                ],
                [
                    'attribute' => 'from_number',
                    'format' => 'raw',
                    'value' => function ($model) use ($phoneNumberUtil) {
                        /** @var \maxodrom\mangooffice\models\events\Call $model */
                        if (preg_match('/^\d+$/', $model->from_number)) {
                            $fromNumberObject = $phoneNumberUtil->parse($model->from_number, 'RU');
                            $fromNumber = $phoneNumberUtil->format($fromNumberObject, PhoneNumberFormat::INTERNATIONAL);
                        } else {
                            if (empty($model->from_number)) {
                                $fromNumber = 'не удалось определить';
                            } else {
                                $fromNumber = $model->from_number;
                            }
                        }

                        return Html::tag(
                            'span',
                            $fromNumber,
                            [
                                'class' => 'label label-' . ($fromNumber == 'не удалось определить' ? 'default' : 'primary'),
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
                            /** @var \maxodrom\mangooffice\models\events\Call $model */
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