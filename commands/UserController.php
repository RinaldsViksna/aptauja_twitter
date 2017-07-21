<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;

/**
 * User actions
 *
 * Register users
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UserController extends Controller
{
    /**
     * Register user via command line
     * @param string $name
     * @param string $password
     * @param string $role
     */
    public function actionRegister($name, $password)
    {
        $model = new User();
        $model->password = User::cryptPassword($password);
        $model->name = $name;
        $model->role = "admin";
        if ($model->save())
        {
        	echo "User created\r\n";
        } else {
        	echo "User not created\r\n";
        	var_dump($model->getErrors());
        }
    }
    
    /**
     * set new password
     * @param string $name
     * @param string $password
     */
    public function actionPassword ($name, $password)
    {
        $user = User::findByEmail($name);
        
        if (!$user)
        {
            throw new \Exception("user not found");
        }
        
        $user->password = User::cryptPassword($password);
        
        if (!$user->save())
        {
            throw new \Exception("cannot save user passwor");
        }
        
        return 0;
    }
    
    /**
     * list all users
     */
    public function actionIndex ()
    {
        $users = User::find()->all();
        
        foreach ($users as $user)
        {
            /* @var app\models\User $user  */
            printf ("%s\t%s\n", $user->name, $user->role);
        }
        return 0;
    }
}
