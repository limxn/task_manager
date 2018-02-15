<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_log`.
 * Has foreign keys to the tables:
 *
 * - `task`
 * - `user`
 */
class m180211_162029_create_task_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('task_log', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `task_id`
        $this->createIndex(
            'idx-task_log-task_id',
            'task_log',
            'task_id'
        );

        // add foreign key for table `task`
        $this->addForeignKey(
            'fk-task_log-task_id',
            'task_log',
            'task_id',
            'task',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-task_log-user_id',
            'task_log',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-task_log-user_id',
            'task_log',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `task`
        $this->dropForeignKey(
            'fk-task_log-task_id',
            'task_log'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            'idx-task_log-task_id',
            'task_log'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-task_log-user_id',
            'task_log'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-task_log-user_id',
            'task_log'
        );

        $this->dropTable('task_log');
    }
}
