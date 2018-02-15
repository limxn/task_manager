<?php
/**
 * Created by PhpStorm.
 * User: package
 * Date: 09.02.18
 * Time: 16:01
 */

namespace app\commands;


use app\models\User;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class AdminController extends Controller
{
    public $email;
    public $password;
    public $name;

    public function options($actionID)
    {
        return ['email','password','name'];
    }

    public function optionAliases()
    {
        return ['n' => 'name','e' => 'email','p' => 'password'];
    }

    public function actionCreate()
    {
        $user = User::register($this->name,$this->email,$this->password);
        if (!$user->save()) {
            $this->stdout("Ошибка создания пользователя\n", Console::FG_RED);
        } else {

            $authManager = Yii::$app->getAuthManager();
            $role = $authManager->getRole('admin');
            $authManager->assign($role, $user->id);

            $this->stdout("Администратор сохранен\n", Console::FG_GREEN);
        }

    }
}