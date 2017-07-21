<?php

namespace app\commands;

use yii\console\Controller;
use yii;

/**
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LessController extends Controller
{
    /**
     * 
     * @param string $source
     * @param string $destination
     */
    public function actionCompile ($source, $destination)
    {
        if (!file_exists($source))
        {
            echo "file does not exist\n";
            return 1;
        }
        
        if (!($handler = fopen($destination, "w")))
        {
            echo "destination file not writeable\n";
            return 1;
        }
        
        fclose($handler);
        
        $options = [];
        /* $options = 
        [
            'sourceMap' => true,
            'sourceMapWriteTo' => "/home/uldis/public_html/lfk.lv/web/css/less.map",
            'sourceMapURL' => "/~uldis/lfk.lv/web/css/less.map"
        ]; */
        
        $less = new \Less_Parser($options);
        $less->parseFile($source);
        
        file_put_contents($destination, $less->getCss());
    }
}
