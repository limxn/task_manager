<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 010 10.02.18
 * Time: 13:12
 */

namespace app\repositories;


use app\models\Task;

class TaskRepository
{
    public function save(Task $task)
    {
        if(!$task->save()){
            throw new \Exception('Ошибка сохранения задачи');
        }
    }
}