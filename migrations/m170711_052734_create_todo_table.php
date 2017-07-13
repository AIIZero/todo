<?php

use yii\db\Migration;

/**
 * Handles the creation of table `todo`.
 */
class m170711_052734_create_todo_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('todo', [
            'id' => $this->primaryKey(),
            'target' => $this->string()->notNull(),
            'microtime' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'status' => $this->integer(),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('todo');
    }
}
