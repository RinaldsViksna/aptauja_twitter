<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LessAsset extends AssetBundle
{
    public $basePath = null;
    
    public $sourcePath = '@app/assets/less';
    public $css = [
        //'style.less'//Commented out to deploy to hostinger.com // Write directly to style.css
    ];
}

