<?php
/**
 * Created by PhpStorm.
 * User: package
 * Date: 15.02.18
 * Time: 14:55
 */

namespace app\widgets;


use app\models\TaskLog;
use app\utils\TaskLogPresenter;
use yii\bootstrap\Widget;

class TaskLogWidget extends Widget
{
    /**
     * @var Task
     */
    public $task;

    public function run()
    {
        $logs = $this->task->getTaskLogs()
            ->orderBy(['id' => SORT_ASC])
            ->all();

        return $this->render('log/index', [
            'task' => $this->task,
            'items' => array_map([$this,'buildPresenter'],$logs),
        ]);
    }

    private function buildPresenter(TaskLog $log)
    {
        return new TaskLogPresenter($log);
    }
}