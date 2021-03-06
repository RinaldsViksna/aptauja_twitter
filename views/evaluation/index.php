<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Evaluations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evaluation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Evaluation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tweet_id',
            'user_id',
            'sentiment_id',
            'is_latvian',
            // 'session',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
