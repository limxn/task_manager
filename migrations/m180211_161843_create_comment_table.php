<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 * Has foreign keys to the tables:
 *
 * - `task`
 */
class m180211_161843_create_comment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'body' => $this->text(),
            'image_path' => $this->string(),
            'task_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `task_id`
        $this->createIndex(
            'idx-comment-task_id',
            'comment',
            'task_id'
        );

        // add foreign key for table `task`
        $this->addForeignKey(
            'fk-comment-task_id',
            'comment',
            'task_id',
            'task',
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
            'fk-comment-task_id',
            'comment'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            'idx-comment-task_id',
            'comment'
        );

        $this->dropTable('comment');
    }
}
