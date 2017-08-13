<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
//  * @property string $password
 * @property string $password_hash
 * @property integer $birth_year
 * @property string $education
 * @property string $auth_key
 * @property string $role
 *
 * @property Evaluations[] $evaluations
 * @property string $username
 * @property string $password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_USER = "user";
    const ROLE_ADMIN = "admin";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'password_hash'], 'required'],
            [['birth_year'], 'integer'],
            [['role'], 'default', 'value' => User::ROLE_USER],
            [['name','password', 'password_hash', 'education', 'auth_key', 'role'], 'string', 'max' => 255],
            ['name', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Šis lietotājvārds ir aizņemts.'],//Yii::t('app/user', 'Šis lietotājvārds ir aizņemts.')],
        		
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [ 
            'id' => Yii::t ( 'app/user', 'ID' ),
            'name' => Yii::t ( 'app/user', 'Lietotājvārds' ),
            'password' => Yii::t( 'app/user', 'Parole' ),
            // 'password_hash' => 'Password Hash',
			'birth_year' => Yii::t( 'app/user', 'Dzimšanas gads'),
        	'education' => Yii::t( 'app/user', 'Izglītība')
        ];
    }
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getEvaluations() {
		return $this->hasMany ( Evaluation::className (), [ 
				'user_id' => 'id' 
		] );
	}
	
	public function getRoles()
	{
	    return [
	        'user' => Yii::t('app/user', 'Lietotājs'),
	        'admin' => Yii::t('app/user', 'Administrators'),
	    ];
	}
	
	public static function findIdentity($id) {
		return static::findOne ( $id );
	}
	
	/**
	 * @param string $name
	 * @return User
	 */
	public static function findByName($name)
	{
	    return static::findOne(['name' => $name]);
	}
	
	public static function findIdentityByAccessToken($token, $type = null) {
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
		return static::findOne ( [ 
				'access_token' => $token 
		] );
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getAuthKey() {
	    return true;
		return $this->authKey;
	}
	
	public function validateAuthKey($authKey) {
	    return true;
		return $this->authKey === $authKey;
	}
	
	public function validatePassword ($password)
	{
	    return $this->password_hash== User::cryptPassword($password);
	}
	
	public function getRole()
	{
	    return $this->role;
	}
	
	public function getUsername(){
	    return $this->name;
	}
	
	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * get temporary variable password
	 */
	public function getPassword()
	{
		return "";
	}
	
	/**
	 * set temporary variable password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}
	
	public static function cryptPassword($password)
	{
	    if (!Yii::$app->params["salt"])
	    {
	        throw new \Exception("salt not defined");
	    }
	    
	    return crypt($password, Yii::$app->params["salt"]);
	}
}
