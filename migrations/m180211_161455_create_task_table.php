<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 * Has foreign keys to the tables:
 *
 * - `project`
 * - `user`
 */
class m180211_161455_create_task_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'body' => $this->text(),
            'project_id' => $this->integer()->notNull(),
            'image_path' => $this->string(),
            'user_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'estimated_time' => $this->integer(),
        ]);

        // creates index for column `project_id`
        $this->createIndex(
            'idx-task-project_id',
            'task',
            'project_id'
        );

        // add foreign key for table `project`
        $this->addForeignKey(
            'fk-task-project_id',
            'task',
            'project_id',
            'project',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-task-user_id',
            'task',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-task-user_id',
            'task',
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
        // drops foreign key for table `project`
        $this->dropForeignKey(
            'fk-task-project_id',
            'task'
        );

        // drops index for column `project_id`
        $this->dropIndex(
            'idx-task-project_id',
            'task'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-task-user_id',
            'task'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-task-user_id',
            'task'
        );

        $this->dropTable('task');
    }
}
