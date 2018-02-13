<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 013 13.02.18
 * Time: 22:07
 */
namespace app\events;

use app\models\Task;

class NewTaskEvent
{
    public $task;
    public $userId;

    public function __construct(Task $task,$userId)
    {
        $this->task = $task;
        $this->userId = $userId;
    }
}