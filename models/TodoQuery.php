<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ToDo]].
 *
 * @see ToDo
 */
class TodoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ToDo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ToDo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
