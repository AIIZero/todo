<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[User2]].
 *
 * @see User2
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return User2[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return User2|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
