<?php

use yii\db\Migration;

/**
 * Handles adding status_old_id to table `task_log`.
 */
class m180215_111951_add_status_old_id_column_to_task_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('task_log', 'status_old_id', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('task_log', 'status_old_id');
    }
}
