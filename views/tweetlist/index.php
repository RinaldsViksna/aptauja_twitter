<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tweetlist';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tweetlist-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'text',
            'user',
        	'username',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
