<?php
/**
 * Created by PhpStorm.
 * User: package
 * Date: 08.02.18
 * Time: 12:51
 */

namespace app\services\managers;


use yii\rbac\ManagerInterface;

class RoleManager
{
    private $authManager;
    private $defaulterRole = 'user';

    public function __construct(ManagerInterface $authManager)
    {
        $this->authManager = $authManager;
    }

    public function createUserRole($userId)
    {
        $role = $this->authManager->getRole($this->defaulterRole);
        if(!$role){
            throw new \Exception('Ошибка user не существует');
        }
        $this->authManager->revokeAll($userId);
        $this->authManager->assign($role,$userId);
    }

}