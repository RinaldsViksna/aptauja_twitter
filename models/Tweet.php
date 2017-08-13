<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tweets".
 * Table tweets contains tweets ready for evaluation. Tweets have only 
 * basic attributes: id, text, link to user profile
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
    
    /**
     * Get random model(s) from table
     * @see \yii\db\ActiveQuey
     * @param array|string|null (optional) $columns Columns to be fetched (default: all columns)
     * @param array $options Additional options pass to function<br>
     * <code>
     *  (array) condition Where Condition
     *  (int) limit Number of models (default: 1)
     *  (bool) asArray Return model attributes as [key=>value] array
     *  (callable) callback Apply a callback on ActiveQuery
     *    function ( \yii\db\ActiveQuery $query ){
     *      // some logic here ...
     *    }
     * </code>
     * @return array|null|\yii\db\ActiveRecord|\yii\db\ActiveRecord[]
     */
    public static function getRandom ( $columns = null, array $options = [] )
    {
        $condition = isset($options['condition']) ? $options['condition'] : [];
        $asArray = isset($options['asArray']) ? $options['asArray'] : false;
        $callback = isset($options['callback']) ? $options['callback'] : null;
        $limit = isset($options['limit']) ? $options['limit'] : 1;
        
        $query = static::find()
        ->select($columns)
        ->where($condition)
        ->orderBy(new \yii\db\Expression('rand()'))
        ->limit((int)$limit);
        
        if ( $asArray ) {
            $query->asArray(true);
        }
        if ( is_callable($callback) ) {
            call_user_func_array($callback, [&$query]);
        }
        return $limit === 1 ? $query->one() : $query->all();
    }
    //**** Example
    /*
     $random = Unit::getRandom('id', [
     //'condition'=>'',
     ]);
     */
}
