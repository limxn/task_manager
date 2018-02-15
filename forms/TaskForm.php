<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 012 12.02.18
 * Time: 22:38
 */

namespace app\forms;


use app\models\Project;
use app\models\Task;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class TaskForm extends Model
{
    public $title;
    public $body;
    public $project_id;
    public $user_id;
    public $image;
    public $estimated_time;

    private $project;
    public function __construct(Project $project,Task $task = null,array $config = [])
    {
        $this->project = $project;
        $this->project_id = $project->id;
        if($task){
            $this->title = $task->title;
            $this->body = $task->body;
            $this->estimated_time = $task->estimated_time;
            $this->image = $task->image_path;

        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'project_id', 'user_id'], 'required'],
            [['body'], 'string'],
            [['project_id', 'user_id','estimated_time'], 'integer'],
            ['image', 'image'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'project_id' => 'Проект',
            'user_id' => 'Назначить',
            'estimated_time' => 'Время выполнения',
            'image' => 'Изображение'
        ];
    }

    public function beforeValidate()
    {
        if(parent::beforeValidate()){
            $this->image = UploadedFile::getInstance($this, 'image');
            return true;
        }
        return false;
    }

    public function getUsers()
    {
        return ArrayHelper::map($this->project->users,'id','name');
    }
}