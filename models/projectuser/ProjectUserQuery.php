<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 012 12.02.18
 * Time: 21:02
 */
namespace app\models\projectuser;
class ProjectUserQuery extends \yii\db\ActiveQuery
{
    public function notAdmin($user_id)
    {
        return $this->andWhere(['user_id' => $user_id,'is_admin' => null]);
    }

    public function project($project_id)
    {
        return $this->andWhere(['project_id' => $project_id]);
    }
}