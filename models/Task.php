<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $project_id
 * @property string $image_path
 * @property int $user_id
 * @property int $status_id
 * @property int $estimated_time
 *
 * @property Comment[] $comments
 * @property User $user
 * @property Project $project
 * @property TaskLog[] $taskLogs
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'project_id', 'user_id', 'status_id'], 'required'],
            [['body'], 'string'],
            [['project_id', 'user_id', 'status_id', 'estimated_time'], 'integer'],
            ['image_path','string'],
            ['title', 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'body' => 'Описание',
            'project_id' => 'Project ID',
            'image_path' => 'Изображение',
            'user_id' => 'User ID',
            'status_id' => 'Status ID',
            'estimated_time' => 'Оценка времени',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['task_id' => 'id']);
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
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskLogs()
    {
        return $this->hasMany(TaskLog::className(), ['task_id' => 'id']);
    }

    public static function create($title,$body,$user_id,$project_id,$estimated_time)
    {
        $task = new self();
        $task->title = $title;
        $task->body = $body;
        $task->project_id = $project_id;
        $task->user_id = $user_id;
        $task->estimated_time = $estimated_time;
        $task->changeNewStatus();
        return $task;
    }

    public function isNewStatus()
    {
        return $this->status_id === 1;
    }
    public function changeNewStatus()
    {
        if($this->isNewStatus()){
            throw new \Exception('Ошибка статуса');
        }
        $this->status_id = 1;
    }

    public function addComment($comment)
    {
        $this->populateRelation('comment', $comment);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $related = $this->getRelatedRecords();
            /** @var User $user */
            if (isset($related['comment']) && $comment = $related['comment']) {
                $comment->task_id = $this->id;
                $comment->save();
            }
            return true;
        }
        return false;
    }

    public function addImage($imagePath)
    {
        $this->image_path = $imagePath;
    }

}
