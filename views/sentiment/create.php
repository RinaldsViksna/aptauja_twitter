<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sentiment */

$this->title = 'Create Sentiment';
$this->params['breadcrumbs'][] = ['label' => 'Sentiments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sentiment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
