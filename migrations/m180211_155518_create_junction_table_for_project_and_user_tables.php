<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project_user`.
 * Has foreign keys to the tables:
 *
 * - `project`
 * - `user`
 */
class m180211_155518_create_junction_table_for_project_and_user_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('project_user', [
            'project_id' => $this->integer(),
            'user_id' => $this->integer(),
            'is_admin' => $this->smallInteger(),
            'PRIMARY KEY(project_id, user_id)',
        ]);

        // creates index for column `project_id`
        $this->createIndex(
            'idx-project_user-project_id',
            'project_user',
            'project_id'
        );

        // add foreign key for table `project`
        $this->addForeignKey(
            'fk-project_user-project_id',
            'project_user',
            'project_id',
            'project',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-project_user-user_id',
            'project_user',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-project_user-user_id',
            'project_user',
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
            'fk-project_user-project_id',
            'project_user'
        );

        // drops index for column `project_id`
        $this->dropIndex(
            'idx-project_user-project_id',
            'project_user'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-project_user-user_id',
            'project_user'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-project_user-user_id',
            'project_user'
        );

        $this->dropTable('project_user');
    }
}
