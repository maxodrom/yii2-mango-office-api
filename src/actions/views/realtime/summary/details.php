<?php
/**
 * Mango Office API Yii2 module.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-mango-office-api
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

/** @var \yii\web\View $this */
/** @var \yii\data\ArrayDataProvider $dataProvider */

$this->title = 'Детализация звонка';
?>
<div class="panel">
    <div class="panel-body">

        <?= $this->render('../call/_expand-row-details', [
            'dataProvider' => $dataProvider,
        ]) ?>

    </div>
</div>