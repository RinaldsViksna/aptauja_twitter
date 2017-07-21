<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evaluations".
 *
 * @property integer $id
 * @property integer $tweet_id
 * @property integer $user_id
 * @property integer $sentiment_id
 * @property integer $is_latvian
 * @property string $session // saved, if user is Anonymous
 *
 * @property Sentiments $sentiment
 * @property Tweets $tweet
 * @property Users $user
 */
class Evaluation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tweet_id', 'sentiment_id'], 'required'],
            [['tweet_id', 'user_id', 'sentiment_id', 'is_latvian'], 'integer'],
            [['session'], 'string', 'max' => 255],
            [['sentiment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sentiment::className(), 'targetAttribute' => ['sentiment_id' => 'id']],
            [['tweet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tweet::className(), 'targetAttribute' => ['tweet_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tweet_id' => 'Tweet ID',
            'user_id' => 'User ID',
            'sentiment_id' => 'Sentiment ID',
            'is_latvian' => 'Is Latvian',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentiment()
    {
        return $this->hasOne(Sentiment::className(), ['id' => 'sentiment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTweet()
    {
        return $this->hasOne(Tweet::className(), ['id' => 'tweet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
