<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Evaluation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evaluation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tweet_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'sentiment_id')->textInput() ?>

    <?= $form->field($model, 'is_latvian')->textInput() ?>

    <?= $form->field($model, 'session')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
