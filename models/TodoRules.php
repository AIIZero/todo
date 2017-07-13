<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "todo_rules".
 *
 * @property integer $todo_id
 * @property integer $user_id
 * @property integer $edit
 */
class TodoRules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'todo_rules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['todo_id', 'user_id', 'edit'], 'required'],
            [['todo_id', 'user_id', 'edit'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'todo_id' => 'Todo ID',
            'user_id' => 'User ID',
            'edit' => 'Edit',
        ];
    }

    /**
     * @inheritdoc
     * @return TodoRulesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TodoRulesQuery(get_called_class());
    }
}
