<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

AppAsset::register($this);

$items = [
		//['label' => Yii::t('app', 'Galvenā'), 'url' => ['/site/index']],
		//['label' => Yii::t('app', 'Par projektu'), 'url' => ['/site/about']],
];
if (Yii::$app->getUser()->isGuest){
	$items[]=['label' => Yii::t('app', 'Reģistrēties'), 'url' => ['/user/create']];
	$items[]=['label' => Yii::t('app', 'Ienākt'), 'url' => ['/user/login']];
}
if (Yii::$app->user->identity && Yii::$app->user->identity->getRole () == User::ROLE_USER) {
    $items [] = [ 'label' => Yii::t ( 'app', 'Profils' ),'url' => ['/user/update','id'=>Yii::$app->getUser()->identity->getId()] ];
    $items [] = '<li>' . Html::beginForm ( ['/user/logout' ], 'post' ) . Html::submitButton ( Yii::t ( 'app', 'Logout' ) . '(' . Yii::$app->user->identity->username . ')',	['class' => 'btn btn-link logout'])
			. Html::endForm()
			. '</li>';
}
if (Yii::$app->user->identity && Yii::$app->user->identity->getRole () == User::ROLE_ADMIN){
	$items[]= ['label' => Yii::t('app', 'Tweets'), 'url' => ['/tweet/index']];
	//$items[]= ['label' => 'Tweetlist'), 'url' => ['/tweetlist/index']];
	$items[]= ['label' => Yii::t('app', 'Sentiments'), 'url' => ['/sentiment/index']];
	$items[]= ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']];
	$items[]= ['label' => Yii::t('app', 'Evaluations'), 'url' => ['/evaluation/index']];
	$items[]= '<li>'
		. Html::beginForm(['/user/logout'], 'post')
		. Html::submitButton(
				Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->username . ')',
			['class' => 'btn btn-link logout']
			)
			. Html::endForm()
			. '</li>';
}

if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <?php

    NavBar::begin([
//        [   'label' => "Novērtē tvītu", 'url' => ['/site/index'],'options'=>['class'=>'center header-title']],
//         'brandLabel' => Html::tag('h1','Novērtē tvītu', ['class'=>'center header-title']),
        'brandLabel' => 'Novērtē tvītu',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>

</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Rinalds Vīksna <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
