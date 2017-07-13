<?php

namespace app\models;

use Yii;
use app\models\TodoRules;

/**
 * This is the model class for table "todo".
 *
 * @property integer $id
 * @property string $target
 * @property integer $microtime
 * @property integer $user_id
 * @property integer $status
 */
class ToDo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'todo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['target', 'microtime'], 'required'],
            [['microtime', 'user_id', 'status'], 'integer'],
            [['target'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'target' => 'Target',
            'microtime' => 'Microtime',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }

    /**
     * @inheritdoc
     * @return TodoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TodoQuery(get_called_class());
    }

    public function getTodoRules()
    {
        return $this->hasMany(TodoRules::className(), ['todo_id' => 'id']);
    }
}
