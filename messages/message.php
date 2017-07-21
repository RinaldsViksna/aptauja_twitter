<?php
use app\modules\siteLanguages\models\Languages;

return [
	'sourcePath' => __DIR__ . '/../',
	'messagePath' => __DIR__,
	'languages' => ['lv'],
	'translator' => 'Yii::t',
	'sort' => true,
	'overwrite' => true,
	'removeUnused' => true,
	'only' => ['*.php'],
	'except' => [
		'.svn',
		'.git',
		'.gitignore',
		'.gitkeep',
		'.hgignore',
		'.hgkeep',
		'/messages',
		'/migrations',
		'/vendor',
		'/runtime',
		'/tests',
		'/config',
	],
	'format' => 'php',
];
