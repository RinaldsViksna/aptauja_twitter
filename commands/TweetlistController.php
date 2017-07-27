<?php

namespace app\commands;

use Yii;
use app\models\Tweetlist;
use yii\data\ActiveDataProvider;
// use yii\web\Controller;
use yii\console\Controller;
use yii\web\NotFoundHttpException;
use app\models\Tweet;

/**
 * TweetlistController extracts Tweets from raw tweetlist and saves them to Tweet table
 */
class TweetlistController extends Controller
{

    /**
     * Lists all Tweetlist models.
     * @return mixed
     */
//     public function actionIndex()
//     {
//         $dataProvider = new ActiveDataProvider([
//             'query' => Tweetlist::find(),
//         ]);

//         return $this->render('index', [
//             'dataProvider' => $dataProvider,
//         ]);
//     }

    /**
     * Displays a single Tweetlist model.
     * @param integer $id
     * @return mixed
     */
//     public function actionView($id)
//     {
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
//     }
    
    /**
     * Check Tweetlist objects if they have been saved in Tweet objects
     * if not, save relevant data in Tweet object
     * Call using console:  ./yii tweetlist/transform 884132677439426560
     */
    public function actionTransform($start = 0){
        $start = (int)$start;
        $c = 1;
        $count = Tweetlist::find()->count("id > $start");
        $connection = Yii::$app->db;
        $command = $connection->createCommand ( "select id from ". Tweetlist::tableName() ." where id > {$start} order by id;" );
        $dataReader = $command->query ();
        $row = null;
        
        while(($row = $dataReader->read()) !== false){
            $c++;
            if ($c%100==0){
                print ($c . "/$count  " . $row['id'] . "\n");
            }
            
            $rawTweet = Tweetlist::findOne($row["id"]);
            
            if ($tweet = Tweet::findOne($row["id"])){
                continue;
            }
            
            $tweet = new Tweet();
            $tweet->id = $rawTweet->id;
            $tweet->text = $rawTweet->text;
            $tweet->author_name = $rawTweet->username;
            $tweet->author_pic = $rawTweet->userImageUrl;
            $tweet->author_profile = $rawTweet->userUrl;
            
            if (!$tweet->save()){
                print("save failed on id: ". $tweet->id);
            }
        }
    }



    /**
     * Finds the Tweetlist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tweetlist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tweetlist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
