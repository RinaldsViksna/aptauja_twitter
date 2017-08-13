<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tweetlist". 
 * Tweetlist table contains raw tweets downloaded from twitter. 
 *
 * @property integer $id
 * @property string $text
 * @property string $user
 * @property string $username
 * @property string $userUrl
 * @property string $userImageUrl
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
	    $user_a = $this->getUserAsArray();
	    return isset($user_a["name"]) ? substr($user_a["name"], 1, -1) : null;
	}
	
	public function getUserImageUrl(){
	    $user_a = $this->getUserAsArray();
	    return isset($user_a["profileImageUrl"]) ? substr($user_a["profileImageUrl"], 1, -1) : null;
	}
	
	public function getUserUrl(){
	    $user_a = $this->getUserAsArray();
	    return isset($user_a["id"]) ? "https://twitter.com/intent/user?user_id=" . $user_a["id"]: null;
	}
	
	/**
	 * Transform TwitterJSON to array
	 * Returns associative array with string values in quotes
	 * @return array
	 */
	private function getUserAsArray(){
        $pattern = '/(?<={)[^}]*(?=})/';
	    preg_match_all($pattern, $this->user, $matches);
	    if (!isset($matches[0][0])){
	        return null;
	    }
	    $user = $matches[0][0]; // bez {}
	    $user= explode(',', $user);
	    $user_a = [];
	    foreach ($user as $attribute){
	        $temp = [];
	        parse_str ( $attribute, $temp);
	        $user_a = array_merge($user_a, $temp);
	    }
	    return $user_a;
	}

}
