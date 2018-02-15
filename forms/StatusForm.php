<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 012 12.02.18
 * Time: 22:38
 */

namespace app\forms;

use app\models\Task;
use app\utils\StatusUtils;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class StatusForm extends Model
{
    public $status_id;
    /**
     * @var Task
     */
    public $task_id;

    private $user;
    private $task;

    public function __construct(Task $task,$user = null,array $config = [])
    {

        $this->task_id = $task->id;
        $this->status_id = $task->status_id;
        $this->task = $task;
        $this->user = $user;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'status_id'], 'required'],
            [['task_id', 'status_id'], 'integer'],
            ['status_id','in','range' => [1,2,3,4]],
            ['status_id','validateDuplicate'],
            ['status_id', 'validateAdmin']
        ];
    }

    public function validateDuplicate($attribute, $params)
    {
        if($this->hasErrors()){
            return;
        }
        if($this->status_id == $this->task->status_id){
            $this->addError($attribute, 'Статус уже назначен');
        }

    }

    public function validateAdmin($attribute, $params)
    {
        if($this->hasErrors()){
            return;
        }
        if($this->status_id == 4 && !$this->user->can('projectPanel',['project' => $this->task->project])){
            $this->addError($attribute, 'Нет прав закрыть задачу');
        }

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'Статус',
        ];
    }


    public function getStatus()
    {
        return ArrayHelper::map(StatusUtils::getStatus(),'id','name');
    }
}