<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tweetlist".
 *
 * @property integer $id
 * @property string $text
 * @property string $user
 * @property string $username
 * @property string $user_profile
 * @property string $user_pic
 *
 * @property Evaluations[] $evaluations
 */
class Tweetlist extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'tweetlist';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['id','text','user'], 'required'],
				[['text', 'user'], 'string'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
				'id' => 'ID',
				'text' => 'Text',
				'user' => 'Tweet Author',
		];
	}
	
	public function getUsername()
	{
		$pattern = '/\{([^}]+)\}/';
		preg_match_all($pattern, $this->user, $matches);
		$user = $matches[0][0];
		$username = json_decode($user);
		print_r($user);
		echo json_last_error_msg();
		print_r($username); exit;
		return $username;
	}

}
