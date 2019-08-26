<?php

/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 02.08.2019
 * Time: 19:29
 * Telegram: @JamalWeb
 */

/* @var $this \yii\web\View
 * @var $list \yii\mongodb\Collection check\
 * @var $provider  = массив чеков
 */

use yii\grid\GridView;

?>

<h1>Мой покупки</h1>

<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        '_id',
        'cashTotalSum',
        'dateTime',
        'ecashTotalSum',
        'fiscalDocumentNumber',
        'fiscalDriveNumber',
        'fiscalSign',
        'operationType',
        'user',
        'userInn',
    ],
]); ?>