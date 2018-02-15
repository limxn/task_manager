<?php
namespace app\forms;

use yii\base\Model;

class RegisterForm extends Model
{
    public $email;
    public $password;
    public $password_repeat;
    public $name;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password','password_repeat','name'], 'required'],
            ['email','email'],
            ['password_repeat','compare','compareAttribute' => 'password']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Электронный адрес',
            'password' => 'Пароль',
            'password_repeat' => 'Повторный пароль',
            'name' => 'Имя'
        ];
    }
}