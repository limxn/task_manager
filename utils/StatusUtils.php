<?php

namespace app\utils;
use yii\helpers\ArrayHelper;

class StatusUtils
{
    public static function getStatus()
    {
        return  [
            ['id' => 1,'name' => 'Новая'],
            ['id' => 2, 'name' => 'В работе'],
            ['id' => 3, 'name' => 'Решена'],
            ['id' => 4, 'name' => 'Закрыта'],
        ];
    }

    public static function getStatusById($id)
    {
        $status = ArrayHelper::index(self::getStatus(),'id');
        return ArrayHelper::getValue($status,$id);
    }
}