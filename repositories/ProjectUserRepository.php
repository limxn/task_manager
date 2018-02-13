<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 012 12.02.18
 * Time: 21:13
 */

namespace app\repositories;


use app\models\ProjectUser;

class ProjectUserRepository
{
    public function findNotAdminUser($projec_id,$user_id)
    {
        return ProjectUser::find()->project($projec_id)->notAdmin($user_id)->one();
    }

    public function save(ProjectUser $projectUser)
    {
        if(!$projectUser->save()){
            throw new \Exception('Ошибка сохранения');
        }
    }
}