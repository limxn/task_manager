<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 013 13.02.18
 * Time: 21:59
 */

namespace app\repositories;


use app\models\TaskLog;

class TaskLogRepository
{
    public function save(TaskLog $log)
    {
        if(!$log->save()){
            throw new \Exception('Ошибка лог не может быть записан');
        }
    }
}