<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\forms\LoginForm;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {
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
                            'login',
                        	'create'
                        ],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->getUser()->isGuest;
                        },
                        'denyCallback' => function ($rule, $action) {
                            return $this->redirect ( Url::toRoute ( [ 
                                "user/login" 
                            ] ) );
                        } 
                    ],
                    [
                        'actions' => [ 
                            'index',
                            'delete',
                            'update',
                            'update-pw',
                            'create',
                            'view' 
                        ],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (Yii::$app->user->identity && Yii::$app->user->identity->getRole () == "admin");
                        } 
                    ],
                    [
                        'actions' => [
                            'update',
                            'view'
                        ],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (Yii::$app->user->identity && (Yii::$app->user->identity->getId() == Yii::$app->request->get('id')));
                        }
                        ],
                    [
                        'actions' => [ 
                            'login',
                            'logout' 
                        ],
                        'allow' => true,
                        'roles' => [ 
                            '@' 
                        ] 
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

    public function actionLogin()
    {
        Yii::$app->user->logout(); //Ja nav, tad met erroru par sessiju
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Yii::$app->getHomeUrl ());
        }
        
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }
    
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User ();
        
        if (Yii::$app->request->isAjax) {
            $model->load ( Yii::$app->request->post () );
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate ( $model );
        }
        $model->load ( Yii::$app->request->post () );
        $model->password_hash = User::cryptPassword ( $model->password );
        // $model->setPassword($model->password);
        $model->role = User::ROLE_USER;
        
        if (Yii::$app->user->identity && $model->save ()) {
            return $this->redirect ( [ 
                'view',
                'id' => $model->id 
            ] );
        } elseif ($model->save ()) {
            Yii::$app->user->login ( $model, 3600 * 24 * 30 );
            return $this->redirect ( [ 
                'update' 
            ] );
        } else {
            return $this->render ( 'create', [ 
                'model' => $model 
            ] );
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if (Yii::$app->request->isAjax) {
            $model->load ( Yii::$app->request->post () );
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate ( $model );
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdatePw($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()))
        {
            if (isset(Yii::$app->request->post()["User"]["password"]) &&
                    \Yii::$app->params["salt"] != substr(Yii::$app->request->post()["User"]["password"], 0, strlen(\Yii::$app->params["salt"] )) )
            {
                $model->password_hash = User::cryptPassword($model->password);
            }
            
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update_pw', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
