<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180211_155055_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'email' => $this->string(),
            'name' => $this->string(),
            'password_hash' => $this->string(),
            'auth_key' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
