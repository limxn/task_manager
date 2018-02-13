<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 013 13.02.18
 * Time: 21:56
 */
namespace app\dispatchers;

class EventDispatcher
{
    private $listeners = [];

    public function __construct(array $listeners)
    {
        $this->listeners = $listeners;
    }

    public function dispatch($event)
    {
        $eventName = get_class($event);
        if (isset($this->listeners[$eventName]) && $klass = $this->listeners[$eventName]) {
            call_user_func([\Yii::createObject($klass), 'handle'], $event);
        }
    }
}