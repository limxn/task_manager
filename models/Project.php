<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 *
 * @property ProjectUser[] $projectUsers
 * @property User[] $users
 * @property Task[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название проекта',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('project_user', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['project_id' => 'id']);
    }

    public function bind($users)
    {

    }

    /**
     * @throws \Exception
     */
    public function add(User $user)
    {
        $users = $this->users;
        foreach ($users as $projectUser) {
            /** @var User $projectUser */
            if($projectUser->isEqual($user)){
                throw new \Exception('Пользователь существует в проекте');
            }
        }
        $this->populateRelation('user', $user);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $related = $this->getRelatedRecords();
            /** @var User $user */
            if (isset($related['user']) && $user = $related['user']) {
                $this->link('users',$user);
            }
            return true;
        }
        return false;
    }

    public function addAdmin($user)
    {
        $users = $this->users;
        foreach ($users as $projectUser) {
            /** @var User $projectUser */
            if($projectUser->isEqual($user) && !$projectUser->isAdmin($user)){

            }
        }
        throw new \Exception('Ошибка пользователь не может быть назначен администратором');
    }
}
