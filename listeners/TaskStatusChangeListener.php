<?php
/**
 * Created by PhpStorm.
 * User: package
 * Date: 15.02.18
 * Time: 14:15
 */

namespace app\listeners;


use app\events\TaskStatusChangeEvent;
use app\models\TaskLog;
use app\repositories\TaskLogRepository;

class TaskStatusChangeListener
{
    /**
     * @var TaskLogRepository
     */
    private $taskLogRepository;

    public function __construct(TaskLogRepository $taskLogRepository)
    {
        $this->taskLogRepository = $taskLogRepository;
    }

    public function handle(TaskStatusChangeEvent $event)
    {
        $log = TaskLog::change($event->newStatusId,$event->oldStatusId,$event->taskId,$event->userId);
        $this->taskLogRepository->save($log);
    }
}