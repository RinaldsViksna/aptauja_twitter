<?php

use yii\helpers\Html;
use app\models\Sentiment;

/* @var $this yii\web\View */
/* @var $model app\models\Tweet */

$this->title = $model->id;
?>
<div class="tweet-eval center">

    <div class="row">
    	
    	<div class="tweet-display">
    	   		<?= Html::a(Html::img(
                $model->author_pic,
                ['alt'=>$model->author_name]), 
   		        $model->author_profile, ['class'=>"img-author",'target'=>'_blank']
                )?>
           		<div class="tweet-text">
           		<?php 
            		$text = $model->text;
            		//echo $text."<br>";
            		//echo json_encode($text);
               		echo Html::a($text,"https://twitter.com/statuses/".Html::encode($this->title),['target'=>'_blank']) ;
           		?>
        		</div>
        		<div class="clearfix"></div>
    	</div>
    	

	</div>
	<div class="evaluation-buttons row">
	<h3>Augstāk redzamajā tvītā ir izteikta...</h3>
    <?php 
        // Sentiment consists of id and string
        $sentiments = Sentiment::find()->all();
        foreach ($sentiments as $sentiment) {
            echo Html::a($sentiment->sentiment,['rate','id'=>$model->id,'sentiment'=>$sentiment->id],['class' => 'btn btn-primary']);
        }
        echo Html::a("Tvīts nav latviešu valodā",['rate','id'=>$model->id,'latvian'=>false],['class' => 'btn btn-danger']);
    ?>
    </div>
    <div class="row"><h3 class="message"><?= $message ?></h3></div>
    <div class="row help">
    	<div class="col-md-4 center">
    		<h2>Kas šī ir par vietni?</h2>
    		<p>Šī vietne ir izveidota, lai apmācītu datoru noteikt teksta emocionālo noskaņu. Lai izveidotu sistēmu, kas to spēs, ir nepieciešami apmācības piemēri. Katrs novērtētais tvīts ir šāds piemērs. Jo vairāk apmācības piemēru izdosies savākt, jo labāk varēs apmācīt sistēmu. Tādēļ lūdzu novērtēt pēc iespējas lielāku tvītu skaitu!  </p>
    	</div>
    	<div class="col-md-4 center">
    		<h2>Kā novērtēt tvītu?</h2>
    		<p>Izlasi tvītu un nospied pogu, kas vislabāk izsaka noskaņojumu, ko tvīta rakstītājs ir domājis izteikt. Ir vairāki iespējamie novērtējumi:</p>
    		<p>Pozitīvs - tvīts  izsaka pozitīvas emocijas.</p>
    		<p>Negatīvs - tvīts ir dusmīgs, drūms utml.</p>
    		<p>Neitrāls - tvīts ir sausi fakti, vai emocija nav vērtējama pozitīvs-negatīvs griezumā.</p>
    		<p>Nesaprotams - nav saprotams, ko tvīta autors ir gribējis izteikt.</p>
    	</div>
    	<div class="col-md-4 center">
    		<h2>Kādēļ reģistrēties?</h2>
    		<p>Lai reģistrētos pietiek norādīt lietotājvārdu un paroli. Reģistrēto lietotāju vērtējumi ir "ticamāki". Reģistrācija ļauj grupēt vērtējumus un izsekot, kā katrs lietotājs ir vērtējis tvītus. </p>
    	</div>
    </div>
</div>
