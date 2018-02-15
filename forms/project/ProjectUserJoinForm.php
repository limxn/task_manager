<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 011 11.02.18
 * Time: 22:36
 */

namespace app\forms\project;


use app\models\Project;
use app\models\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ProjectUserJoinForm extends Model
{
    public $project_id;
    public $user_id;

    public function __construct(Project $project, array $config = [])
    {
        parent::__construct($config);
        $this->project_id = $project->id;
    }

    public function rules()
    {
        return [
            // username and password are both required
            [['user_id', 'project_id'], 'required'],
            [['user_id', 'project_id'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'Пользователь'
        ];
    }

    public function getUsers()
    {
        return ArrayHelper::map(User::find()->all(),'id','name');
    }

}