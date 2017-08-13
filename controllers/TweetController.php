<?php

namespace app\controllers;

use Yii;
use app\models\Tweet;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Sentiment;
use app\models\Evaluation;
use yii\filters\AccessControl;
use app\models\User;

/**
 * TweetController implements the CRUD actions for Tweet model.
 */
class TweetController extends Controller {
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [ 
            'access' => [ 
                'class' => AccessControl::className (),
                'rules' => [
                    [
                        'actions' => [ 
                        	'index',
                        	'view',
                            'create',
                            'delete',
                            'update',
                        	'rate',
                        ],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (Yii::$app->user->identity && Yii::$app->user->identity->getRole () == User::ROLE_ADMIN);
                        } 
                    ],
                    [
                        'actions' => [ 
//                             'index',
//                             'view',
                            'rate'
                        ],
                        'allow' => true,
                        'roles' => [
                            '?'
                        ] 
                    ],
                    [
                    		'actions' => [
//                     				'index',
//                     				'view',
                    				'rate'
                    		],
                    		'allow' => true,
                    		'matchCallback' => function ($rule, $action) {
                    			return (Yii::$app->user->identity && Yii::$app->user->identity->getRole () == User::ROLE_USER);
                    		} 
                    ] 
                ] 
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tweet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tweet::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tweet model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Display single Tweet model for evaluation
     * If no $id given, display random Tweet
     * @param int $id tweet id, for rating
     * @param int $sentiment - sentiment id, for rating
     * @param bool $latvian - if false, tweet is not in latvian language
     */
    public function actionRate($id = null, $sentiment = null, $latvian = true){
        
        if ($sentiment){
            $sentiment = Sentiment::findOne($sentiment);
        }
        $message = "";
        if ($id){
        	$model = $this->findModel($id);
            $evaluation = new Evaluation([
                'tweet_id' => $model->id,
                'sentiment_id' => $sentiment ? $sentiment->id : null,
            ]);
            $evaluation->is_latvian = $latvian ? 1 : 0;
            $evaluation->user_id = Yii::$app->user->isGuest ? null : Yii::$app->user->id;
            $evaluation->session = Yii::$app->session->id;
            
            $message = $evaluation->save() ? "Paldies par vērtējumu!" : "Novērtejumu saglabāt neizdevās";
            //print_r($evaluation->getErrors());
            //exit();
        } 

        // AJAX
        if (Yii::$app->request->isAjax){
            return $this->renderPartial('evaluate',[
                'model' => Tweet::getRandom(),
                'message'=> $message,
            ]);
        }
        
        return $this->render('evaluate', [
            'model' => Tweet::getRandom(),
            'message'=> $message,
        ]);
    }

    /**
     * Creates a new Tweet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tweet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tweet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tweet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tweet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tweet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tweet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
