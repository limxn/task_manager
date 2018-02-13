<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 010 10.02.18
 * Time: 15:08
 */

namespace app\rback;


use app\models\Project;
use yii\rbac\Item;
use yii\rbac\Rule;

class ProjectAdminRule extends Rule
{

    public $name = 'Администратор проекта';
    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if(!isset($params['project'])){
            return false;
        }
        /** @var Project $project */
        $project = $params['project'];
        return $project->getProjectUsers()->where(['user_id' => $user,'is_admin' => 1])->exists();
    }
}