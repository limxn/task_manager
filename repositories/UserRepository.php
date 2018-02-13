<?php
namespace app\repositories;

use app\models\User;

class UserRepository
{
    public function findByEmail($email)
    {
        return User::find()->where(['email' => $email])->one();
    }

    public function findById($id)
    {
        return User::findOne($id);
    }

    public function save(User $user)
    {
        if(!$user->save()){
            throw new \Exception('Ошибка сохранения пользователя');
        }
    }

    public function findUsers(array $user_ids)
    {
        return User::find()->where(['in','id',$user_ids])->all();
    }
}