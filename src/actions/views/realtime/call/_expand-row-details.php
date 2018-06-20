<?php

use yii\helpers\Html;
use maxodrom\mangooffice\models\events\Call;

/** @var \maxodrom\mangooffice\models\events\Call[] $models */
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
        <table class="table table-hover table-condensed table-bordered">
            <thead>
            <tr>
                <td>Время события</td>
                <td>Расположение</td>
                <td>SEQ</td>
                <td>Состояние</td>
                <td>Номер вызываемого абонента</td>
                <td>Причина завершения вызова</td>
            </tr>
            </thead>
            <?php foreach ($models as $model): ?>
                <tbody>
                <tr>
                    <td>
                        <?= Yii::$app->formatter->asDatetime($model->timestamp, 'medium'); ?>
                    </td>
                    <td>
                        <span class="label label-<?= Call::getLocationCssClass()[$model->location] ?>">
                            <?= Call::getLocationLabels()[$model->location] ?>
                        </span>
                    </td>
                    <td>
                        <?= $model->seq ?>
                    </td>
                    <td>
                        <span class="label label-<?= Call::getCallStateCssClass()[$model->call_state] ?>">
                           <?= Call::getCallStateLabels()[$model->call_state] ?>
                        </span>

                    </td>
                    <td>
                        <?= $model->to_number ?>
                    </td>
                    <td>
                        <?= $model->disconnect_reason != null ?
                            Html::tag(
                                'span',
                                $model->disconnect_reason,
                                [
                                    'class' => 'label label-primary',
                                    'title' => Call::$resultStatuses[$model->disconnect_reason],
                                ]
                            ) : '';
                        ?>
                    </td>
                </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>
</div>
