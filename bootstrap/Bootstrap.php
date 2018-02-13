<?php

namespace app\bootstrap;

use app\dispatchers\EventDispatcher;
use app\form\project\SearchAdminProject;
use app\form\project\SearchDecoratorProject;
use app\form\project\SearchProjectInterface;
use app\form\project\SearchUserProject;
use app\listeners\TaskStatusListener;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\rbac\ManagerInterface;


class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     * @throws \yii\base\InvalidConfigException
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->setSingleton('app\dispatchers\EventDispatcher', function ($container) {
            return new EventDispatcher([
                'app\events\NewTaskEvent' => TaskStatusListener::class
            ]);
        });
        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->get('authManager');
        });

    }
}