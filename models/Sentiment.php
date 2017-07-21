<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sentiments".
 *
 * @property integer $id
 * @property string $sentiment
 *
 * @property Evaluations[] $evaluations
 */
class Sentiment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sentiments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sentiment'], 'required'],
            [['sentiment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sentiment' => 'Sentiment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluations()
    {
        return $this->hasMany(Evaluation::className(), ['sentiment_id' => 'id']);
    }
}
