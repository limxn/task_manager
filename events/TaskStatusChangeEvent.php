<?php
/**
 * Created by PhpStorm.
 * User: package
 * Date: 15.02.18
 * Time: 14:13
 */

namespace app\events;


class TaskStatusChangeEvent
{

    public $taskId;
    public $newStatusId;
    public $oldStatusId;
    public $userId;

    public function __construct($taskId, $newStatusId, $oldStatusId, $userId)
    {
        $this->taskId = $taskId;
        $this->newStatusId = $newStatusId;
        $this->oldStatusId = $oldStatusId;
        $this->userId = $userId;
    }
}