<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Sentiment;

/* @var $this yii\web\View */
/* @var $model app\models\Tweet */

$this->title = $model->id;
?>
<div class="tweet-eval">

    <h1><?= "Novērtē tvītu  " . Html::encode($this->title) ?></h1>
	
	<div class="row"><?= $message ?></div>
    <div class="row">
   		<?= Html::a(Html::img(
                $model->author_pic,
                ['alt'=>$model->author_name]), 
                $model->author_profile, ['class'=>"img-author"]
            )?>
   		<div class="tweet-text">
   		<?= $model->text ?>
		</div>
	</div>
	<div class="evaluation-buttons row">
    <?php 
        // Sentiment consists of id and string
        $sentiments = Sentiment::find()->all();
        foreach ($sentiments as $sentiment) {
            echo Html::a($sentiment->sentiment,['rate','id'=>$model->id,'sentiment'=>$sentiment->id],['class' => 'btn btn-primary']);
        }
        echo Html::a("Tvīts nav latviešu valodā",['rate','id'=>$model->id,'latvian'=>false],['class' => 'btn btn-danger']);
    ?>
    </div>

    



</div>
