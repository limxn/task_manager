<?php
/**
 * Created by PhpStorm.
 * User: package
 * Date: 15.02.18
 * Time: 15:03
 */

namespace app\utils;


use app\models\TaskLog;

class TaskLogPresenter
{
    /**
     * @var TaskLog
     */
    private $taskLog;

    public function __construct(TaskLog $taskLog)
    {
        $this->taskLog = $taskLog;
    }

    public function name()
    {
        if($this->taskLog->status_id == 1 && empty($this->taskLog->status_old_id)){
            return 'Новая';
        }
        $newStatusName = StatusUtils::getStatusById($this->taskLog->status_id);
        $oldStatusName = StatusUtils::getStatusById($this->taskLog->status_id);
        return sprintf('Статус изменился с %s на %s',$oldStatusName['name'],$newStatusName['name']);
    }
}