<?php
/**
 * Created by PhpStorm.
 * User: package
 * Date: 13.02.18
 * Time: 12:00
 */

namespace app\forms;


use app\models\Task;
use yii\base\Model;
use yii\web\UploadedFile;

class CommentForm extends Model
{

    public $body;
    public $task_id;
    public $user_id;
    public $image;
    /**
     * @var Task
     */
    private $task;

    public function __construct(Task $task,$user_id,array $config = [])
    {
        parent::__construct($config);
        $this->task = $task;
        $this->task_id = $task->id;
        $this->user_id = $user_id;
    }


    public function rules()
    {
        return [
            [['body'], 'string'],
            [['body', 'task_id','user_id'], 'required'],
            ['image', 'image'],
            ['task_id','integer'],
            ['user_id','integer']
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'body' => 'Текст',
            'image' => 'Изображение'
        ];
    }
}