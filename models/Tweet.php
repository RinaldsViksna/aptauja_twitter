<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tweets".
 *
 * @property integer $id
 * @property string $text
 * @property string $author_name
 * @property string $author_profile
 * @property string $author_pic
 *
 * @property Evaluations[] $evaluations
 */
class Tweet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tweets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text', 'author_name', 'author_profile', 'author_pic'], 'string', 'max' => 255],
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
            'author_name' => 'Author Name',
            'author_profile' => 'Author Profile',
            'author_pic' => 'Author Pic',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluations()
    {
        return $this->hasMany(Evaluation::className(), ['tweet_id' => 'id']);
    }
}
