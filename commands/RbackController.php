<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Project;
use app\rback\ProjectAdminRule;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RbackController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll();
        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $auth->add($user);
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);


        $projectPanel = $auth->createPermission('projectPanel');
        $projectPanel->description = 'Работа с проектами';
        $auth->add($projectPanel);

        $projectAdminRule = new ProjectAdminRule();
        $auth->add($projectAdminRule);

        /*
         * если пользователь является администратором проекта
         * */
        $userAdminPanel = $auth->createPermission('userAdminPanel');
        $userAdminPanel->description = 'Работа с проектами где пользователь администратор';
        $userAdminPanel->ruleName = $projectAdminRule->name;
        $auth->add($userAdminPanel);


        $auth->addChild($userAdminPanel,$projectPanel);
        $auth->addChild($user,$userAdminPanel);

        $auth->addChild($admin,$projectPanel);
        $auth->addChild($admin, $user);
    }
}
