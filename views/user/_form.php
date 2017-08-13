<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php 
    $form = ActiveForm::begin([
    		'enableClientValidation' => false,
    		'enableAjaxValidation' => true,
    		'validateOnChange' => false
    ]);

    echo $form->field($model, 'name')->textInput(['maxlength' => true]);

    echo $form->field($model, 'password')->passwordInput(['maxlength' => true]);
    
//     echo "<h3>Lai apkopotu statistiku par vērtētāju optimisma līmeni, lūdzu norādiet arī: </h3>";
    
//     echo $form->field($model, 'birth_year')->textInput();

//     echo $form->field($model, 'education')->textInput(['maxlength' => true]);
//     echo "";
//     echo $form->field($model, 'auth_key')->textInput(['maxlength' => true]);
    
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Reģisrēt lietotāju') : Yii::t('app', 'Labot datus'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
