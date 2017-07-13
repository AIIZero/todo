<?php

use yii\db\Migration;

/**
 * Handles the creation of table `todo_rules`.
 */
class m170711_233323_create_todo_rules_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('todo_rules', [
            'todo_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'edit' => $this->integer()->notNull(),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('todo_rules');
    }
}
