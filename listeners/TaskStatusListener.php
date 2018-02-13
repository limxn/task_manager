<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 013 13.02.18
 * Time: 21:58
 */
namespace app\listeners;

use app\events\NewTaskEvent;
use app\models\TaskLog;
use app\repositories\TaskLogRepository;

class TaskStatusListener
{
    /**
     * @var TaskLogRepository
     */
    private $taskLogRepository;

    public function __construct(TaskLogRepository $taskLogRepository)
    {
        $this->taskLogRepository = $taskLogRepository;
    }

    public function handle(NewTaskEvent $event)
    {
        $log = TaskLog::create($event->task->id,$event->task->status_id,$event->userId);
        $this->taskLogRepository->save($log);
    }
}