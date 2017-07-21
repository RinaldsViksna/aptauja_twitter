<?php
namespace app\components;

use yii\web\AssetConverter;

class TweetAssetConverter extends AssetConverter
{
    public $commands = [
    'less' => ['css', '@app/yii less/compile {from} {to}'],
    'scss' => ['css', 'sass {from} {to} --sourcemap'],
    'sass' => ['css', 'sass {from} {to} --sourcemap'],
    'styl' => ['css', 'stylus < {from} > {to}'],
    'coffee' => ['js', 'coffee -p {from} > {to}'],
    'ts' => ['js', 'tsc --out {to} {from}'],
    ];
    
    public $forceConvert = true;
    
    /**
     * (non-PHPdoc)
     * @see \yii\base\Object::init()
     */
    public function init()
    {
       parent::init();

       if (defined("YII_ENV") && YII_ENV == "dev")
       {
           $this->forceConvert = true;
//            touch (\Yii::$app->view->theme->basePath . '/web');
       }
    }
    
    /**
     *
     */
    public function convert($asset, $basePath)
    {
        return parent::convert($asset, $basePath);
    }
}
