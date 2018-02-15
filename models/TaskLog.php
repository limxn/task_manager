<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_log".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property int $status_id
 * @property int $status_old_id
 *
 * @property User $user
 * @property Task $task
 */
class TaskLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_log';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id', 'status_id'], 'required'],
            [['task_id', 'user_id', 'status_id','status_old_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'status_id' => 'Status ID',
            'status_old_id' => 'Status old id'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    public static function create($taskId,$statusId,$userId)
    {
        $log = new self();
        $log->task_id = $taskId;
        $log->user_id = $userId;
        $log->status_id = $statusId;
        return $log;
    }

    public static function change($newId,$oldId,$taskId,$userId)
    {
        $log = new self();
        $log->task_id = $taskId;
        $log->user_id = $userId;
        $log->status_id = $newId;
        $log->status_old_id = $oldId;
        return $log;
    }
}
